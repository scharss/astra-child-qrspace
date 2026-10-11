<?php
/**
 * QRSpace — Configuración de precios (Mensual / Anual) y conversión de moneda.
 *
 * Añade un menú en la barra lateral de wp-admin para configurar el precio
 * mensual y anual (importe + moneda) y la moneda en la que se muestran. La
 * conversión usa tasas de Yahoo Finance con respaldo er-api y caché.
 *
 * Es independiente del plugin VizorCoin.
 *
 * @package Astra_Child_QRSpace
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'QRSPACE_PRICING_OPTION', 'qrspace_pricing' );
define( 'QRSPACE_RATE_PREFIX', 'qrspace_rate_' );
define( 'QRSPACE_LAST_RATE_OPTION', 'qrspace_last_rate' );

/**
 * Valores por defecto de la configuración.
 *
 * @return array
 */
function qrspace_pricing_defaults() {
	return array(
		'monthly_amount'   => 47,
		'monthly_currency' => 'USD',
		'annual_amount'    => 350,
		'annual_currency'  => 'USD',
		'display_currency' => 'USD',
		'rate_source'      => 'auto',
		'cache_ttl'        => 60,
		'manual_rate'      => '',
	);
}

/**
 * Configuración actual (defaults + guardada).
 *
 * @return array
 */
function qrspace_pricing_settings() {
	$saved = get_option( QRSPACE_PRICING_OPTION, array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	return wp_parse_args( $saved, qrspace_pricing_defaults() );
}

/**
 * Lista de monedas (código => nombre).
 *
 * @return array
 */
function qrspace_currencies() {
	if ( function_exists( 'get_woocommerce_currencies' ) ) {
		return get_woocommerce_currencies();
	}
	return array(
		'USD' => 'Dólar estadounidense',
		'COP' => 'Peso colombiano',
		'EUR' => 'Euro',
		'MXN' => 'Peso mexicano',
		'PEN' => 'Sol peruano',
		'CLP' => 'Peso chileno',
		'ARS' => 'Peso argentino',
		'BRL' => 'Real brasileño',
		'CNY' => 'Yuan chino',
		'GBP' => 'Libra esterlina',
		'CAD' => 'Dólar canadiense',
		'AUD' => 'Dólar australiano',
	);
}

/**
 * Símbolo de una moneda.
 *
 * @param string $code Código ISO.
 * @return string
 */
function qrspace_currency_symbol( $code ) {
	$code = strtoupper( (string) $code );

	if ( function_exists( 'get_woocommerce_currency_symbol' ) ) {
		$symbol = get_woocommerce_currency_symbol( $code );
		if ( $symbol ) {
			return html_entity_decode( $symbol, ENT_QUOTES, 'UTF-8' );
		}
	}

	$map = array(
		'USD' => '$',
		'COP' => '$',
		'EUR' => '€',
		'GBP' => '£',
		'MXN' => '$',
		'PEN' => 'S/',
		'CLP' => '$',
		'ARS' => '$',
		'BRL' => 'R$',
		'CNY' => '¥',
		'JPY' => '¥',
		'CAD' => '$',
		'AUD' => '$',
	);
	return isset( $map[ $code ] ) ? $map[ $code ] : $code;
}

/**
 * Formatea un importe (enteros) con el símbolo de la moneda.
 *
 * @param float  $amount   Importe.
 * @param string $currency Código ISO.
 * @return string
 */
function qrspace_format_money( $amount, $currency ) {
	$currency = strtoupper( (string) $currency );
	$thousand = function_exists( 'wc_get_price_thousand_separator' ) ? wc_get_price_thousand_separator() : ',';
	$decimal  = function_exists( 'wc_get_price_decimal_separator' ) ? wc_get_price_decimal_separator() : '.';
	$number   = number_format( (float) $amount, 0, $decimal, $thousand );
	$symbol   = qrspace_currency_symbol( $currency );

	$pos = get_option( 'woocommerce_currency_pos', 'left' );
	switch ( $pos ) {
		case 'right':
			return $number . $symbol;
		case 'left_space':
			return $symbol . ' ' . $number;
		case 'right_space':
			return $number . ' ' . $symbol;
		default:
			return $symbol . $number;
	}
}

/**
 * Realiza una petición GET y devuelve el JSON decodificado.
 *
 * @param string $url     URL.
 * @param array  $headers Cabeceras extra.
 * @return array|null
 */
function qrspace_http_json( $url, $headers = array() ) {
	$response = wp_remote_get(
		$url,
		array(
			'timeout' => 12,
			'headers' => array_merge( array( 'Accept' => 'application/json' ), $headers ),
		)
	);
	if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
		return null;
	}
	$json = json_decode( wp_remote_retrieve_body( $response ), true );
	return is_array( $json ) ? $json : null;
}

/**
 * Precio de un símbolo FX en Yahoo.
 *
 * @param string $symbol Símbolo (ej. USDCOP).
 * @return float|false
 */
function qrspace_yahoo_price( $symbol ) {
	$url  = 'https://query1.finance.yahoo.com/v8/finance/chart/' . rawurlencode( strtoupper( $symbol ) . '=X' ) . '?interval=1d&range=1d';
	$json = qrspace_http_json( $url, array( 'User-Agent' => 'Mozilla/5.0 (compatible; QRSpace/1.0)' ) );

	if ( is_array( $json ) && isset( $json['chart']['result'][0]['meta']['regularMarketPrice'] ) ) {
		$price = (float) $json['chart']['result'][0]['meta']['regularMarketPrice'];
		if ( $price > 0 ) {
			return $price;
		}
	}
	return false;
}

/**
 * Tasa desde Yahoo Finance (target por 1 base).
 *
 * @param string $base   Base.
 * @param string $target Destino.
 * @return float|false
 */
function qrspace_fetch_yahoo( $base, $target ) {
	$direct = qrspace_yahoo_price( $base . $target );
	if ( $direct && $direct >= 0.01 ) {
		return $direct;
	}
	$inverse = qrspace_yahoo_price( $target . $base );
	if ( $inverse && $inverse > 0 ) {
		$rate = 1 / $inverse;
		if ( $rate > 0 ) {
			return $rate;
		}
	}
	return $direct ? $direct : false;
}

/**
 * Tasa desde open.er-api.com.
 *
 * @param string $base   Base.
 * @param string $target Destino.
 * @return float|false
 */
function qrspace_fetch_er_api( $base, $target ) {
	$url  = 'https://open.er-api.com/v6/latest/' . rawurlencode( strtoupper( $base ) );
	$json = qrspace_http_json( $url );
	if ( is_array( $json ) && isset( $json['rates'][ strtoupper( $target ) ] ) ) {
		$rate = (float) $json['rates'][ strtoupper( $target ) ];
		if ( $rate > 0 ) {
			return $rate;
		}
	}
	return false;
}

/**
 * Devuelve la tasa (target por 1 base).
 *
 * @param string $base   Base.
 * @param string $target Destino.
 * @param bool   $force  Ignorar caché.
 * @return float|false
 */
function qrspace_get_rate( $base, $target, $force = false ) {
	$base   = strtoupper( (string) $base );
	$target = strtoupper( (string) $target );

	if ( '' === $base || '' === $target ) {
		return false;
	}
	if ( $base === $target ) {
		return 1.0;
	}

	$settings = qrspace_pricing_settings();

	if ( '' !== $settings['manual_rate'] && is_numeric( $settings['manual_rate'] ) && (float) $settings['manual_rate'] > 0 ) {
		return (float) $settings['manual_rate'];
	}

	$key = QRSPACE_RATE_PREFIX . $base . '_' . $target;
	if ( ! $force ) {
		$cached = get_transient( $key );
		if ( false !== $cached && is_numeric( $cached ) && (float) $cached > 0 ) {
			return (float) $cached;
		}
	}

	$source  = $settings['rate_source'];
	$sources = ( 'auto' === $source ) ? array( 'yahoo', 'er_api' ) : array( $source );
	$rate    = false;
	$used    = '';

	foreach ( $sources as $candidate ) {
		if ( 'yahoo' === $candidate ) {
			$r = qrspace_fetch_yahoo( $base, $target );
		} elseif ( 'er_api' === $candidate ) {
			$r = qrspace_fetch_er_api( $base, $target );
		} else {
			$r = false;
		}
		if ( $r && $r > 0 ) {
			$rate = $r;
			$used = $candidate;
			break;
		}
	}

	if ( $rate && $rate > 0 ) {
		$ttl = max( 60, absint( $settings['cache_ttl'] ) * MINUTE_IN_SECONDS );
		set_transient( $key, $rate, $ttl );
		update_option(
			QRSPACE_LAST_RATE_OPTION,
			array(
				'base'   => $base,
				'target' => $target,
				'rate'   => (float) $rate,
				'time'   => time(),
				'source' => $used,
			),
			false
		);
		return (float) $rate;
	}

	$last = get_option( QRSPACE_LAST_RATE_OPTION );
	if ( is_array( $last ) && isset( $last['base'], $last['target'], $last['rate'] )
		&& strtoupper( (string) $last['base'] ) === $base
		&& strtoupper( (string) $last['target'] ) === $target
		&& (float) $last['rate'] > 0 ) {
		return (float) $last['rate'];
	}

	return false;
}

/**
 * Convierte un importe de una moneda a otra. Si no hay tasa, devuelve el original.
 *
 * @param float  $amount Importe.
 * @param string $base   Base.
 * @param string $target Destino.
 * @return float
 */
function qrspace_convert( $amount, $base, $target ) {
	$amount = (float) $amount;
	$base   = strtoupper( (string) $base );
	$target = strtoupper( (string) $target );

	if ( $base === $target ) {
		return $amount;
	}
	$rate = qrspace_get_rate( $base, $target );
	if ( ! $rate || $rate <= 0 ) {
		return $amount;
	}
	return $amount * (float) $rate;
}

/**
 * Datos de precio formateados para un periodo.
 *
 * @param string $period monthly|annual.
 * @return array
 */
function qrspace_get_price( $period ) {
	$settings = qrspace_pricing_settings();
	$display  = strtoupper( $settings['display_currency'] );

	if ( 'annual' === $period ) {
		$amount = (float) $settings['annual_amount'];
		$base   = strtoupper( $settings['annual_currency'] );
	} else {
		$amount = (float) $settings['monthly_amount'];
		$base   = strtoupper( $settings['monthly_currency'] );
	}

	$converted = qrspace_convert( $amount, $base, $display );

	return array(
		'raw'      => $amount,
		'base'     => $base,
		'currency' => $display,
		'amount'   => $converted,
		'display'  => qrspace_format_money( $converted, $display ),
	);
}

/* =========================================================================
 * ADMIN
 * ========================================================================= */

add_action( 'admin_menu', 'qrspace_pricing_admin_menu' );

/**
 * Añade el menú lateral.
 */
function qrspace_pricing_admin_menu() {
	add_menu_page(
		'QRSpace',
		'QRSpace',
		'manage_options',
		'qrspace-pricing',
		'qrspace_pricing_render_page',
		'dashicons-tag',
		58
	);
}

add_action( 'admin_init', 'qrspace_pricing_register' );

/**
 * Registra la opción.
 */
function qrspace_pricing_register() {
	register_setting(
		'qrspace_pricing_group',
		QRSPACE_PRICING_OPTION,
		array(
			'type'              => 'array',
			'sanitize_callback' => 'qrspace_pricing_sanitize',
			'default'           => qrspace_pricing_defaults(),
		)
	);
}

/**
 * Sanea la configuración.
 *
 * @param array $input Datos.
 * @return array
 */
function qrspace_pricing_sanitize( $input ) {
	$input     = is_array( $input ) ? $input : array();
	$defaults  = qrspace_pricing_defaults();
	$out       = $defaults;
	$currencies = array_keys( qrspace_currencies() );

	$out['monthly_amount'] = ( isset( $input['monthly_amount'] ) && is_numeric( $input['monthly_amount'] ) ) ? (float) $input['monthly_amount'] : 0;
	$out['annual_amount']  = ( isset( $input['annual_amount'] ) && is_numeric( $input['annual_amount'] ) ) ? (float) $input['annual_amount'] : 0;

	$mc = isset( $input['monthly_currency'] ) ? strtoupper( sanitize_text_field( $input['monthly_currency'] ) ) : 'USD';
	$out['monthly_currency'] = in_array( $mc, $currencies, true ) ? $mc : 'USD';

	$ac = isset( $input['annual_currency'] ) ? strtoupper( sanitize_text_field( $input['annual_currency'] ) ) : 'USD';
	$out['annual_currency'] = in_array( $ac, $currencies, true ) ? $ac : 'USD';

	$dc = isset( $input['display_currency'] ) ? strtoupper( sanitize_text_field( $input['display_currency'] ) ) : 'USD';
	$out['display_currency'] = in_array( $dc, $currencies, true ) ? $dc : 'USD';

	$src = isset( $input['rate_source'] ) ? sanitize_key( $input['rate_source'] ) : 'auto';
	$out['rate_source'] = in_array( $src, array( 'auto', 'yahoo', 'er_api' ), true ) ? $src : 'auto';

	$out['cache_ttl'] = isset( $input['cache_ttl'] ) ? max( 1, absint( $input['cache_ttl'] ) ) : 60;

	$out['manual_rate'] = ( isset( $input['manual_rate'] ) && is_numeric( $input['manual_rate'] ) && (float) $input['manual_rate'] > 0 )
		? (float) $input['manual_rate']
		: '';

	// Limpiar caché de tasas al guardar.
	delete_transient( QRSPACE_RATE_PREFIX . $out['monthly_currency'] . '_' . $out['display_currency'] );
	delete_transient( QRSPACE_RATE_PREFIX . $out['annual_currency'] . '_' . $out['display_currency'] );

	return $out;
}

add_action( 'admin_post_qrspace_refresh_rate', 'qrspace_pricing_refresh_rate' );

/**
 * Fuerza la actualización de la tasa.
 */
function qrspace_pricing_refresh_rate() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Sin permisos.' );
	}
	check_admin_referer( 'qrspace_refresh_rate' );

	$s = qrspace_pricing_settings();
	$target = strtoupper( $s['display_currency'] );
	qrspace_get_rate( strtoupper( $s['monthly_currency'] ), $target, true );
	qrspace_get_rate( strtoupper( $s['annual_currency'] ), $target, true );

	wp_safe_redirect( add_query_arg( 'refreshed', '1', admin_url( 'admin.php?page=qrspace-pricing' ) ) );
	exit;
}

/**
 * Renderiza la pantalla de ajustes.
 */
function qrspace_pricing_render_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$settings   = qrspace_pricing_settings();
	$currencies = qrspace_currencies();
	$monthly    = qrspace_get_price( 'monthly' );
	$annual     = qrspace_get_price( 'annual' );
	$last       = get_option( QRSPACE_LAST_RATE_OPTION );
	?>
	<div class="wrap">
		<h1>QRSpace — Precios</h1>

		<?php if ( isset( $_GET['refreshed'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<div class="notice notice-success is-dismissible"><p>Tasa actualizada.</p></div>
		<?php endif; ?>

		<p>Configura el precio <strong>mensual</strong> y <strong>anual</strong>, su moneda, y la moneda en la que se muestran en la sección de precios de la portada. La conversión es solo visual.</p>

		<form method="post" action="options.php">
			<?php settings_fields( 'qrspace_pricing_group' ); ?>

			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><label for="qrspace_monthly_amount">Precio mensual</label></th>
						<td>
							<input type="number" step="1" min="0" id="qrspace_monthly_amount" name="qrspace_pricing[monthly_amount]" value="<?php echo esc_attr( $settings['monthly_amount'] ); ?>" class="regular-text" />
							<select name="qrspace_pricing[monthly_currency]">
								<?php foreach ( $currencies as $code => $name ) : ?>
									<option value="<?php echo esc_attr( $code ); ?>" <?php selected( strtoupper( $settings['monthly_currency'] ), strtoupper( $code ) ); ?>>
										<?php echo esc_html( $code . ' — ' . $name ); ?>
									</option>
								<?php endforeach; ?>
							</select>
							<p class="description">Importe y moneda del plan mensual (ej. 180000 COP).</p>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="qrspace_annual_amount">Precio anual</label></th>
						<td>
							<input type="number" step="1" min="0" id="qrspace_annual_amount" name="qrspace_pricing[annual_amount]" value="<?php echo esc_attr( $settings['annual_amount'] ); ?>" class="regular-text" />
							<select name="qrspace_pricing[annual_currency]">
								<?php foreach ( $currencies as $code => $name ) : ?>
									<option value="<?php echo esc_attr( $code ); ?>" <?php selected( strtoupper( $settings['annual_currency'] ), strtoupper( $code ) ); ?>>
										<?php echo esc_html( $code . ' — ' . $name ); ?>
									</option>
								<?php endforeach; ?>
							</select>
							<p class="description">Importe y moneda del plan anual.</p>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="qrspace_display_currency">Moneda de visualización</label></th>
						<td>
							<select id="qrspace_display_currency" name="qrspace_pricing[display_currency]">
								<?php foreach ( $currencies as $code => $name ) : ?>
									<option value="<?php echo esc_attr( $code ); ?>" <?php selected( strtoupper( $settings['display_currency'] ), strtoupper( $code ) ); ?>>
										<?php echo esc_html( $code . ' — ' . $name ); ?>
									</option>
								<?php endforeach; ?>
							</select>
							<p class="description">Moneda en la que se muestran los precios en la portada.</p>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="qrspace_rate_source">Fuente de la tasa</label></th>
						<td>
							<select id="qrspace_rate_source" name="qrspace_pricing[rate_source]">
								<option value="auto" <?php selected( $settings['rate_source'], 'auto' ); ?>>Automática (Yahoo + respaldo er-api)</option>
								<option value="yahoo" <?php selected( $settings['rate_source'], 'yahoo' ); ?>>Solo Yahoo Finance</option>
								<option value="er_api" <?php selected( $settings['rate_source'], 'er_api' ); ?>>Solo open.er-api.com</option>
							</select>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="qrspace_cache_ttl">Caché (minutos)</label></th>
						<td>
							<input type="number" min="1" step="1" id="qrspace_cache_ttl" name="qrspace_pricing[cache_ttl]" value="<?php echo esc_attr( $settings['cache_ttl'] ); ?>" class="small-text" />
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="qrspace_manual_rate">Tasa manual (opcional)</label></th>
						<td>
							<input type="text" inputmode="decimal" id="qrspace_manual_rate" name="qrspace_pricing[manual_rate]" value="<?php echo esc_attr( $settings['manual_rate'] ); ?>" class="regular-text" />
							<p class="description">Unidades de la moneda de visualización por 1 unidad de la moneda configurada. Si se indica, se ignora la API y se aplica a ambas conversiones (mensual y anual).</p>
						</td>
					</tr>
				</tbody>
			</table>

			<?php submit_button( 'Guardar cambios' ); ?>
		</form>

		<hr />

		<h2>Vista previa</h2>
		<p>
			<strong>Mensual:</strong> <?php echo esc_html( $monthly['display'] . ' ' . $monthly['currency'] ); ?>
			(<?php echo esc_html( $monthly['raw'] . ' ' . $monthly['base'] ); ?>)<br />
			<strong>Anual:</strong> <?php echo esc_html( $annual['display'] . ' ' . $annual['currency'] ); ?>
			(<?php echo esc_html( $annual['raw'] . ' ' . $annual['base'] ); ?>)
		</p>

		<h2>Estado de la tasa</h2>
		<?php if ( is_array( $last ) && isset( $last['rate'] ) ) : ?>
			<p>
				<?php
				printf(
					'1 %s = %s %s · actualizada el %s · fuente: %s',
					esc_html( $last['base'] ),
					esc_html( number_format_i18n( (float) $last['rate'], 6 ) ),
					esc_html( $last['target'] ),
					esc_html( date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), (int) $last['time'] ) ),
					esc_html( $last['source'] )
				);
				?>
			</p>
		<?php else : ?>
			<p>Aún no hay una tasa registrada.</p>
		<?php endif; ?>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="qrspace_refresh_rate" />
			<?php wp_nonce_field( 'qrspace_refresh_rate' ); ?>
			<?php submit_button( 'Actualizar tasa ahora', 'secondary', 'submit', false ); ?>
		</form>
	</div>
	<?php
}
