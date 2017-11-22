<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| ALLEGRA PLATFORM Config Items
|--------------------------------------------------------------------------
|
| The following items are for use with Allegra.
| victor.hernandez.col@gmail.com
|
*/
// Notification Email
$config['allegra_notify']   = 'victor.hernandez.col@gmail.com';
// Allegra Locale
$config['allegra_locale']   = 'es-CO';
// Allegra Currency
$config['allegra_currency'] = 'COP';
// Allegra Profile ID
$config['allegra_profileid'] = '1C8C6927-F903-4EF2-8031-1417555BF83A';
// Allegra Access Key
$config['allegra_accesskey'] = 'd37871d56b2a3487a4401a27f54e8728';
// Allegra Secret Key
$config['allegra_secretkey'] = 'a45d733a03994f308ffbcdb7117069a3cd61fd64bd3e4705897994257522d82f35d708a2bd284e33ae463100c1b7ccfd4af2de2f21b74a2ea56dbcefea9e39127c539ed0e9724c45b8905862d18b0488747655cdbaf749fd9307276a2b50c7d66759262a0d2a4eff922002ea8953a31459388c9338664e2fb8f5556ce9e5f29d';
// Allegra website URL
$config['allegra_url'] = '2.11.9';
// Allegra url for transactions
$config['allegra_transaction_url'] = 'https://test.secureacceptance.allegraplatform.com/CI_Secure_Acceptance/Payment';
// Products template name or EE routing table name
$config['product_template'] = 'evento';
// Fields to sign
$config['signed_field_names'] = 'access_key,profile_id,reference_number,amount,currency,locale,transaction_type,transaction_uuid, signed_date_time,unsigned_field_names';
// Email Template
$config['allegra_mail_transaction_start'] = 'Email Body template';
