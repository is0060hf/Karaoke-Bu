<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       MIT License (https://opensource.org/licenses/mit-license.php)
 */

/**
 * Use the DS to separate the directories in other defines
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * These defines should only be edited if you have cake installed in
 * a directory layout other than the way it is distributed.
 * When using custom settings be sure to use the DS and do not add a trailing DS.
 */

/**
 * The full path to the directory which holds "src", WITHOUT a trailing DS.
 */
define('ROOT', dirname(__DIR__));

/**
 * The actual directory name for the application directory. Normally
 * named 'src'.
 */
define('APP_DIR', 'src');

/**
 * Path to the application's directory.
 */
define('APP', ROOT . DS . APP_DIR . DS);

/**
 * Path to the config directory.
 */
define('CONFIG', ROOT . DS . 'config' . DS);

/**
 * File path to the webroot directory.
 *
 * To derive your webroot from your webserver change this to:
 *
 * `define('WWW_ROOT', rtrim($_SERVER['DOCUMENT_ROOT'], DS) . DS);`
 */
define('WWW_ROOT', ROOT . DS . 'webroot' . DS);

/**
 * Path to the tests directory.
 */
define('TESTS', ROOT . DS . 'tests' . DS);

/**
 * Path to the temporary files directory.
 */
define('TMP', ROOT . DS . 'tmp' . DS);

/**
 * Path to the logs directory.
 */
define('LOGS', ROOT . DS . 'logs' . DS);

/**
 * Path to the cache files directory. It can be shared between hosts in a multi-server setup.
 */
define('CACHE', TMP . 'cache' . DS);

/**
 * The absolute path to the "cake" directory, WITHOUT a trailing DS.
 *
 * CakePHP should always be installed with composer, so look there.
 */
define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp');

/**
 * Path to the cake directory.
 */
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);

/**
 * 役割コード
 */
define('ROLE_BASIC', '0');
define('ROLE_MANAGER', '1');
define('ROLE_SYSTEM', '9');
define('ROLE_NAME_ARRAY', [
	'-1' => "未選択",
	ROLE_BASIC => "一般ユーザー",
	ROLE_MANAGER => "店舗管理者",
	ROLE_SYSTEM => "システム管理者",
]);

/**
 * チームメンバーステータスコード
 */
define('TEAM_MEMBER_STATUS_APPROVAL', '1');
define('TEAM_MEMBER_STATUS_NON_APPROVAL', '2');
define('TEAM_MEMBER_STATUS_ARRAY', [
	'-1' => "未選択",
	'1' => "承認済み",
	'2' => "非承認",
]);

/**
 * チームメンバー役割
 */
define('TEAM_MEMBER_ROLE_MANAGER', '1');
define('TEAM_MEMBER_ROLE_MEMBER', '2');
define('TEAM_MEMBER_ROLE_ARRAY', [
	'-1' => "未選択",
	'1' => "管理者",
	'2' => "メンバー",
]);

/**
 * ドリンクメニュー
 */
define('DRINK_MENU_NONE', '1');
define('DRINK_MENU_SOFT', '2');
define('DRINK_MENU_ALCOHOL', '3');
define('DRINK_MENU_BRING', '4');
define('DRINK_MENU_ARRAY', [
	'-1' => '未選択',
	'1' => 'オーダー制',
	'2' => 'ドリンクバー',
	'3' => 'アルコール飲み放題',
	'4' => '持ち込み'
]);

/**
 * フードメニュー
 */
define('FOOD_MENU_NONE', '1');
define('FOOD_MENU_COURSE', '2');
define('FOOD_MENU_VIKING', '3');
define('FOOD_MENU_BRING', '4');
define('FOOD_MENU_ARRAY', [
	'-1' => '未選択',
	'1' => 'オーダー制',
	'2' => 'コース',
	'3' => '食べ放題',
	'4' => '持ち込み'
]);

/**
 * 募集範囲
 */
define('LIMITED_RANGE_NONE', '1');
define('LIMITED_RANGE_FRIENDS', '2');
define('LIMITED_RANGE_TEAM', '3');
define('LIMITED_RANGE_ARRAY', [
	'1' => '誰でも応募可能',
	'2' => 'ともだちのみ',
	'3' => 'チームメンバーのみ',
]);

/**
 * 地域
 */
define('REGION_HOKKAIDOU', '1');
define('REGION_TOUHOKU', '2');
define('REGION_KANTOU', '3');
define('REGION_TYUUBU', '4');
define('REGION_KANSAI', '5');
define('REGION_TYUUGOKU', '6');
define('REGION_SHIKOKU', '7');
define('REGION_KYUUSHUU', '8');
define('REGION_ARRAY', [
	'-1' => '未選択',
	REGION_HOKKAIDOU => '北海道地方',
	REGION_TOUHOKU => '東北地方',
	REGION_KANTOU=> '関東地方',
	REGION_TYUUBU => '中部地方',
	REGION_KANSAI => '関西地方',
	REGION_TYUUGOKU => '中国地方',
	REGION_SHIKOKU => '四国地方',
	REGION_KYUUSHUU => '九州地方',
]);

/**
 * 都道府県
 */
define('PREFECTURE_HOKKAIDO', '1');
define('PREFECTURE_AOMORI', '2');
define('PREFECTURE_IWATE', '3');
define('PREFECTURE_MIYAGI', '4');
define('PREFECTURE_AKITA', '5');
define('PREFECTURE_YAMAGATA', '6');
define('PREFECTURE_FUKUSHIMA', '7');
define('PREFECTURE_IBARAGI', '8');
define('PREFECTURE_TOCHIGI', '9');
define('PREFECTURE_GUNMA', '10');
define('PREFECTURE_SAITAMA', '11');
define('PREFECTURE_TOKYO', '12');
define('PREFECTURE_CHIBA', '13');
define('PREFECTURE_KANAGAWA', '14');
define('PREFECTURE_NIIGATA', '15');
define('PREFECTURE_TOYAMA', '16');
define('PREFECTURE_ISHIKAWA', '17');
define('PREFECTURE_HUKUI', '18');
define('PREFECTURE_YAMANASHI', '19');
define('PREFECTURE_NAGANO', '20');
define('PREFECTURE_GIHU', '21');
define('PREFECTURE_SHIZUOKA', '22');
define('PREFECTURE_AICHI', '23');
define('PREFECTURE_MIE', '24');
define('PREFECTURE_SHIGA', '25');
define('PREFECTURE_KYOTO', '26');
define('PREFECTURE_OSAKA', '27');
define('PREFECTURE_HYOGO', '28');
define('PREFECTURE_NARA', '29');
define('PREFECTURE_WAKAYAMA', '30');
define('PREFECTURE_TOTTORI', '31');
define('PREFECTURE_SHIMANE', '32');
define('PREFECTURE_OKAYAMA', '33');
define('PREFECTURE_HIROSHIMA', '34');
define('PREFECTURE_YAMAGUCHI', '35');
define('PREFECTURE_TOKUSHIMA', '36');
define('PREFECTURE_KAGAWA', '37');
define('PREFECTURE_EHIME', '38');
define('PREFECTURE_KOUCHI', '39');
define('PREFECTURE_FUKUOKA', '40');
define('PREFECTURE_SAGA', '41');
define('PREFECTURE_NAGASAKI', '42');
define('PREFECTURE_KUMAMOTO', '43');
define('PREFECTURE_OOITA', '44');
define('PREFECTURE_MIYAZAKI', '45');
define('PREFECTURE_KAGOSHIMA', '46');
define('PREFECTURE_OKINAWA', '47');
define('PREFECTURE_ARRAY', [
	'-1' => '未選択',
	PREFECTURE_HOKKAIDO => '北海道',
	PREFECTURE_AOMORI => '青森',
	PREFECTURE_IWATE => '岩手',
	PREFECTURE_MIYAGI => '宮城',
	PREFECTURE_AKITA => '秋田',
	PREFECTURE_YAMAGATA => '山形',
	PREFECTURE_FUKUSHIMA => '福島',
	PREFECTURE_IBARAGI => '茨城',
	PREFECTURE_TOCHIGI => '栃木',
	PREFECTURE_GUNMA => '群馬',
	PREFECTURE_SAITAMA => '埼玉',
	PREFECTURE_TOKYO => '東京',
	PREFECTURE_CHIBA => '千葉',
	PREFECTURE_KANAGAWA => '神奈川',
	PREFECTURE_NIIGATA => '新潟',
	PREFECTURE_TOYAMA => '富山',
	PREFECTURE_ISHIKAWA => '石川',
	PREFECTURE_HUKUI => '福井',
	PREFECTURE_YAMANASHI => '山梨',
	PREFECTURE_NAGANO => '長野',
	PREFECTURE_GIHU => '岐阜',
	PREFECTURE_SHIZUOKA => '静岡',
	PREFECTURE_AICHI => '愛知',
	PREFECTURE_MIE => '三重',
	PREFECTURE_SHIGA => '滋賀',
	PREFECTURE_KYOTO => '京都',
	PREFECTURE_OSAKA => '大阪',
	PREFECTURE_HYOGO => '兵庫',
	PREFECTURE_NARA => '奈良',
	PREFECTURE_WAKAYAMA => '和歌山',
	PREFECTURE_TOTTORI => '鳥取',
	PREFECTURE_SHIMANE => '島根',
	PREFECTURE_OKAYAMA => '岡山',
	PREFECTURE_HIROSHIMA => '広島',
	PREFECTURE_YAMAGUCHI => '山口',
	PREFECTURE_TOKUSHIMA => '徳島',
	PREFECTURE_KAGAWA => '香川',
	PREFECTURE_EHIME => '愛媛',
	PREFECTURE_KOUCHI => '高知',
	PREFECTURE_FUKUOKA => '福岡',
	PREFECTURE_SAGA => '佐賀',
	PREFECTURE_NAGASAKI => '長崎',
	PREFECTURE_KUMAMOTO => '熊本',
	PREFECTURE_OOITA => '大分',
	PREFECTURE_MIYAZAKI => '宮崎',
	PREFECTURE_KAGOSHIMA => '鹿児島',
	PREFECTURE_OKINAWA => '沖縄'
]);

/**
 * 地方と都道府県のマッピング表
 */
define('REGION_PREFECTURE_MAPPING', [
	-1 => [],
	REGION_HOKKAIDOU => [
		PREFECTURE_HOKKAIDO
	],
	REGION_TOUHOKU => [
		PREFECTURE_AOMORI,
		PREFECTURE_IWATE ,
		PREFECTURE_MIYAGI,
		PREFECTURE_AKITA,
		PREFECTURE_YAMAGATA,
		PREFECTURE_FUKUSHIMA
	],
	REGION_KANTOU=> [
		PREFECTURE_IBARAGI,
		PREFECTURE_TOCHIGI,
		PREFECTURE_GUNMA,
		PREFECTURE_SAITAMA,
		PREFECTURE_TOKYO,
		PREFECTURE_CHIBA,
		PREFECTURE_KANAGAWA
	],
	REGION_TYUUBU => [
		PREFECTURE_NIIGATA,
		PREFECTURE_TOYAMA,
		PREFECTURE_ISHIKAWA,
		PREFECTURE_HUKUI,
		PREFECTURE_YAMANASHI,
		PREFECTURE_NAGANO,
		PREFECTURE_GIHU,
		PREFECTURE_SHIZUOKA,
		PREFECTURE_AICHI
	],
	REGION_KANSAI => [
		PREFECTURE_MIE,
		PREFECTURE_SHIGA,
		PREFECTURE_KYOTO,
		PREFECTURE_OSAKA,
		PREFECTURE_HYOGO,
		PREFECTURE_NARA,
		PREFECTURE_WAKAYAMA
	],
	REGION_TYUUGOKU => [
		PREFECTURE_TOTTORI,
		PREFECTURE_SHIMANE,
		PREFECTURE_OKAYAMA,
		PREFECTURE_HIROSHIMA,
		PREFECTURE_YAMAGUCHI
	],
	REGION_SHIKOKU => [
		PREFECTURE_TOKUSHIMA,
		PREFECTURE_KAGAWA,
		PREFECTURE_EHIME,
		PREFECTURE_KOUCHI
	],
	REGION_KYUUSHUU => [
		PREFECTURE_FUKUOKA,
		PREFECTURE_SAGA,
		PREFECTURE_NAGASAKI,
		PREFECTURE_KUMAMOTO,
		PREFECTURE_OOITA,
		PREFECTURE_MIYAZAKI,
		PREFECTURE_KAGOSHIMA,
		PREFECTURE_OKINAWA
	]
]);

// カバー画像のアップロード制限は10MBとする
define('UPLOAD_COVER_IMAGE_CAPACITY', 10000000);

// アイコン画像のアップロード制限は1MBとする
define('UPLOAD_ICON_IMAGE_CAPACITY', 1000000);

define('MAIL_FROM_ADDRESS', 'info@taylormode.co.jp');
define('MAIL_FROM_NAME', 'カラオケ部');

define('AUTH_MAIL_TITLE', '【カラオケ部】仮登録完了のお知らせ');
define('AUTH_MAIL_BODY', 'この度は、「カラオケ部」にお申し込み頂きまして
誠にありがとうございます。

お申し込み頂きましたアカウント情報は以下となります。

　ログインID：{{_$1_}}
　パスワード：個人情報のため表示を伏せています

ご本人様確認のため、下記URLへ「24時間以内」にアクセスし
アカウントの本登録を完了させて下さい。
{{_$2_}}

※当メール送信後、24時間を超過しますと、セキュリティ保持のため有効期限切れとなります。
　その場合は再度、最初からお手続きをお願い致します。

※お使いのメールソフトによってはURLが途中で改行されることがあります。
　その場合は、最初の「http://」から末尾の英数字までをブラウザに
　直接コピー＆ペーストしてアクセスしてください。

※当メールは送信専用メールアドレスから配信されています。
　このままご返信いただいてもお答えできませんのでご了承ください。

※当メールに心当たりの無い場合は、誠に恐れ入りますが
　破棄して頂けますよう、よろしくお願い致します。');

define('UPDATE_PASSWORD_MAIL_TITLE', '【カラオケ部】パスワード変更のお知らせ');
define('UPDATE_PASSWORD_MAIL_BODY', '「カラオケ部」をご利用頂きましてありがとうございます。
この度は、パスワード変更を承りましたことをお知らせいたします。

お申し込み頂きましたアカウント情報は以下となります。

　ログインID：{{_$1_}}
　パスワード：個人情報のため表示を伏せています

※当メールは送信専用メールアドレスから配信されています。
　このままご返信いただいてもお答えできませんのでご了承ください。

※当メールに心当たりの無い場合は、誠に恐れ入りますが
　破棄して頂けますよう、よろしくお願い致します。');

