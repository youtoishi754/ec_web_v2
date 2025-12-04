-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2025-12-04 14:44:11
-- サーバのバージョン： 10.4.13-MariaDB
-- PHP のバージョン: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `laravel`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `m_order_statuses`
--

CREATE TABLE `m_order_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL COMMENT 'ステータス名',
  `rank` int(11) NOT NULL COMMENT '表示順'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `m_order_statuses`
--

INSERT INTO `m_order_statuses` (`id`, `name`, `rank`) VALUES
(1, '注文確定', 1),
(2, '入金確認済', 3),
(3, '発送準備中', 4),
(4, '発送済み', 5),
(5, '配達完了', 6),
(6, 'キャンセル', 99),
(7, '返品受付中', 100),
(8, '返品完了', 101),
(9, '決済未完了', 0),
(10, '入金未完了', 2);

-- --------------------------------------------------------

--
-- テーブルの構造 `m_payment_methods`
--

CREATE TABLE `m_payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '支払方法名',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '有効フラグ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `m_payment_methods`
--

INSERT INTO `m_payment_methods` (`id`, `name`, `is_active`) VALUES
(1, 'クレジットカード', 1),
(2, '代金引換', 1),
(3, '銀行振込', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `m_prefectures`
--

CREATE TABLE `m_prefectures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(10) NOT NULL COMMENT '都道府県名',
  `code` char(2) NOT NULL COMMENT 'JISコード'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `m_prefectures`
--

INSERT INTO `m_prefectures` (`id`, `name`, `code`) VALUES
(1, '北海道', '01'),
(2, '青森県', '02'),
(3, '岩手県', '03'),
(4, '宮城県', '04'),
(5, '秋田県', '05'),
(6, '山形県', '06'),
(7, '福島県', '07'),
(8, '茨城県', '08'),
(9, '栃木県', '09'),
(10, '群馬県', '10'),
(11, '埼玉県', '11'),
(12, '千葉県', '12'),
(13, '東京都', '13'),
(14, '神奈川県', '14'),
(15, '新潟県', '15'),
(16, '富山県', '16'),
(17, '石川県', '17'),
(18, '福井県', '18'),
(19, '山梨県', '19'),
(20, '長野県', '20'),
(21, '岐阜県', '21'),
(22, '静岡県', '22'),
(23, '愛知県', '23'),
(24, '三重県', '24'),
(25, '滋賀県', '25'),
(26, '京都府', '26'),
(27, '大阪府', '27'),
(28, '兵庫県', '28'),
(29, '奈良県', '29'),
(30, '和歌山県', '30'),
(31, '鳥取県', '31'),
(32, '島根県', '32'),
(33, '岡山県', '33'),
(34, '広島県', '34'),
(35, '山口県', '35'),
(36, '徳島県', '36'),
(37, '香川県', '37'),
(38, '愛媛県', '38'),
(39, '高知県', '39'),
(40, '福岡県', '40'),
(41, '佐賀県', '41'),
(42, '長崎県', '42'),
(43, '熊本県', '43'),
(44, '大分県', '44'),
(45, '宮崎県', '45'),
(46, '鹿児島県', '46'),
(47, '沖縄県', '47');

-- --------------------------------------------------------

--
-- テーブルの構造 `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `payment_logs`
--

CREATE TABLE `payment_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `stripe_payment_intent_id` varchar(255) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `error_message` text DEFAULT NULL,
  `request_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`request_data`)),
  `response_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`response_data`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `pre_registrations`
--

CREATE TABLE `pre_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `t_favorites`
--

CREATE TABLE `t_favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `goods_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `t_favorites`
--

INSERT INTO `t_favorites` (`id`, `user_id`, `goods_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2025-11-28 15:34:18', '2025-11-28 15:34:18'),
(2, 3, 5, '2025-11-28 15:34:19', '2025-11-28 15:34:19');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_goods`
--

CREATE TABLE `t_goods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `un_id` varchar(255) DEFAULT NULL,
  `goods_number` varchar(255) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL COMMENT '商品画像パス',
  `goods_price` int(11) DEFAULT NULL,
  `tax_rate` int(11) NOT NULL DEFAULT 10 COMMENT '税率',
  `goods_stock` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL COMMENT 'カテゴリID',
  `goods_detail` text DEFAULT NULL,
  `intro_txt` text DEFAULT NULL,
  `disp_flg` tinyint(4) NOT NULL DEFAULT 1,
  `delete_flg` tinyint(4) NOT NULL DEFAULT 0,
  `sales_start_at` datetime DEFAULT NULL COMMENT '販売開始日時',
  `sales_end_at` datetime DEFAULT NULL COMMENT '販売終了日時',
  `ins_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `up_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `t_goods`
--

INSERT INTO `t_goods` (`id`, `un_id`, `goods_number`, `goods_name`, `image_path`, `goods_price`, `tax_rate`, `goods_stock`, `category_id`, `goods_detail`, `intro_txt`, `disp_flg`, `delete_flg`, `sales_start_at`, `sales_end_at`, `ins_date`, `up_date`) VALUES
(1, 'G0001', 'ITEM-001', 'クラシックロゴTシャツ ホワイト', 'sample_01.jpg', 3500, 10, 43, 1, '定番のロゴTシャツ。コットン100%で着心地抜群です。', '【人気No.1】どんなスタイルにも合わせやすい一枚。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-12-04 11:22:37'),
(2, 'G0002', 'ITEM-002', 'クラシックロゴTシャツ ブラック', 'sample_02.jpg', 3500, 10, 34, 1, '定番のロゴTシャツのブラックカラー。', 'シックに決まるブラック。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-12-04 11:56:31'),
(3, 'G0003', 'ITEM-003', 'ヴィンテージデニムパンツ', 'sample_03.jpg', 12800, 10, 8, 2, 'こだわりのウォッシュ加工を施したデニム。', '履き込むほどに味が出る本格派。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-12-04 12:02:23'),
(4, 'G0004', 'ITEM-004', 'スリムフィットチノパン ベージュ', 'sample_04.jpg', 8900, 10, 20, 2, 'オフィスカジュアルにも使えるきれいめチノパン。', 'ストレッチ素材で動きやすい。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-12-04 11:49:42'),
(5, 'G0005', 'ITEM-005', 'オーバーサイズパーカー グレー', 'sample_05.jpg', 6500, 10, 15, 1, 'ゆったりとしたシルエットのパーカー。裏起毛で暖かい。', 'トレンドのオーバーサイズシルエット。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(6, 'G0006', 'ITEM-006', 'レザーショルダーバッグ', 'sample_06.jpg', 15000, 10, 7, 3, '本革を使用した高級感のあるショルダーバッグ。', '使い込むほどに馴染む本革仕様。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-12-03 14:23:54'),
(7, 'G0007', 'ITEM-007', 'キャンバストートバッグ', 'sample_07.jpg', 2500, 10, 100, 3, '大容量で丈夫なキャンバス生地のトートバッグ。', '通学・通勤に便利なサイズ感。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(8, 'G0008', 'ITEM-008', 'ハイカットスニーカー 赤', 'sample_08.jpg', 7800, 10, 25, 4, '足元のアクセントになる赤いスニーカー。', 'クラシックなデザインが魅力。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(9, 'G0009', 'ITEM-009', 'ランニングシューズ', 'sample_09.jpg', 9800, 10, 40, 4, '軽量でクッション性の高いランニングシューズ。', '毎日の運動をサポート。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(10, 'G0010', 'ITEM-010', 'ニットキャップ ネイビー', 'sample_10.jpg', 1800, 10, 59, 3, 'シンプルなリブ編みのニット帽。', '秋冬の必須アイテム。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-12-03 15:17:16'),
(11, 'G0011', 'ITEM-011', 'チェック柄マフラー', 'sample_11.jpg', 3200, 10, 35, 3, '暖かみのあるチェック柄のマフラー。', 'ギフトにもおすすめ。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(12, 'G0012', 'ITEM-012', 'ダウンジャケット 黒', 'sample_12.jpg', 24000, 10, 10, 1, '真冬でも暖かい高機能ダウンジャケット。', '軽量なのに驚きの暖かさ。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(13, 'G0013', 'ITEM-013', 'ボーダーカットソー', 'sample_13.jpg', 4200, 10, 55, 1, 'マリンテイストなボーダー柄の長袖Tシャツ。', '春先にぴったりの爽やかさ。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(14, 'G0014', 'ITEM-014', 'プリーツスカート ピンク', 'sample_14.jpg', 5600, 10, 22, 2, '動くたびに揺れる上品なプリーツスカート。', 'フェミニンなコーディネートに。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(15, 'G0015', 'ITEM-015', 'ワイドパンツ カーキ', 'sample_15.jpg', 6800, 10, 28, 2, 'リラックス感のあるワイドシルエットのパンツ。', 'ウエストゴムで楽な履き心地。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(16, 'G0016', 'ITEM-016', 'シルバーネックレス', 'sample_16.jpg', 8500, 10, 15, 3, 'シンプルなデザインのシルバー925ネックレス。', 'どんな服装にも合わせやすい。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(17, 'G0017', 'ITEM-017', 'レザーベルト 茶', 'sample_17.jpg', 3800, 10, 40, 3, '牛革を使用したベーシックなベルト。', 'ビジネスにもカジュアルにも。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(18, 'G0018', 'ITEM-018', 'サングラス', 'sample_18.jpg', 4500, 10, 30, 3, 'UVカット機能付きのサングラス。', '夏の日差し対策に。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(19, 'G0019', 'ITEM-019', 'スポーツソックス 3足組', 'sample_19.jpg', 1000, 10, 200, 3, '吸汗速乾性に優れたスポーツソックス。', 'お得な3足セット。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(20, 'G0020', 'ITEM-020', 'リネンシャツ 白', 'sample_20.jpg', 5900, 10, 30, 1, '通気性の良いリネン素材のシャツ。', '夏でも涼しく快適。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(21, 'G0021', 'ITEM-021', 'カーゴパンツ', 'sample_21.jpg', 7500, 10, 25, 2, '機能的なポケットが特徴のカーゴパンツ。', 'ミリタリーテイストを取り入れて。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(22, 'G0022', 'ITEM-022', 'ショートパンツ デニム', 'sample_22.jpg', 4800, 10, 40, 2, '夏に大活躍のデニムショートパンツ。', '海やフェスに最適。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(23, 'G0023', 'ITEM-023', 'サンダル 黒', 'sample_23.jpg', 3500, 10, 60, 4, '歩きやすいスポーツサンダル。', '夏のレジャーに。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(24, 'G0024', 'ITEM-024', 'ビジネスシューズ', 'sample_24.jpg', 12000, 10, 20, 4, '本革を使用したストレートチップシューズ。', '冠婚葬祭にも使えるフォーマルな一足。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(25, 'G0025', 'ITEM-025', '腕時計 アナログ', 'sample_25.jpg', 18000, 10, 10, 3, 'シンプルで見やすい文字盤の腕時計。', '毎日の生活に寄り添うデザイン。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(26, 'G0026', 'ITEM-026', 'ワイヤレスイヤホン', 'sample_26.jpg', 8900, 10, 50, 3, '高音質の完全ワイヤレスイヤホン。', '通勤通学の必需品。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(27, 'G0027', 'ITEM-027', 'スマホケース iPhone15用', 'sample_27.jpg', 2500, 10, 80, 3, '耐衝撃性に優れたスマホケース。', '大切なスマホを守ります。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(28, 'G0028', 'ITEM-028', 'モバイルバッテリー', 'sample_28.jpg', 3000, 10, 60, 3, '大容量10000mAhのモバイルバッテリー。', '外出時の充電切れも安心。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(29, 'G0029', 'ITEM-029', 'ヨガマット', 'sample_29.jpg', 2800, 10, 30, 3, '厚さ10mmでクッション性の高いヨガマット。', '自宅でのトレーニングに。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(30, 'G0030', 'ITEM-030', 'プロテイン シェイカー付き', 'sample_30.jpg', 4500, 8, 40, 5, '飲みやすいココア味のホエイプロテイン。', '理想のカラダ作りをサポート。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(31, 'G0031', 'ITEM-031', 'オーガニックコットンタオル', 'sample_31.jpg', 1500, 10, 100, 3, '肌に優しいオーガニックコットン100%。', '敏感肌の方にもおすすめ。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(32, 'G0032', 'ITEM-032', 'アロマディフューザー', 'sample_32.jpg', 4800, 10, 20, 3, '超音波式のアロマディフューザー。', 'お部屋を癒しの空間に。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(33, 'G0033', 'ITEM-033', 'コーヒーメーカー', 'sample_33.jpg', 8500, 10, 15, 3, '手軽に本格的なコーヒーが楽しめる。', '忙しい朝にぴったり。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(34, 'G0034', 'ITEM-034', 'マグカップ ペアセット', 'sample_34.jpg', 3000, 10, 25, 3, 'おしゃれなデザインのマグカップ2個セット。', 'プレゼントにも最適。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(35, 'G0035', 'ITEM-035', '観葉植物 パキラ', 'sample_35.jpg', 2500, 10, 10, 3, '育てやすい観葉植物。', 'お部屋のインテリアに緑を。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(36, 'G0036', 'ITEM-036', 'LEDデスクライト', 'sample_36.jpg', 3800, 10, 30, 3, '目に優しいLEDデスクライト。調光機能付き。', '学習や読書に。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(37, 'G0037', 'ITEM-037', 'ゲーミングマウス', 'sample_37.jpg', 5500, 10, 20, 3, '高精度のセンサーを搭載したゲーミングマウス。', '快適なゲームプレイを実現。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(38, 'G0038', 'ITEM-038', 'キーボード メカニカル', 'sample_38.jpg', 9800, 10, 15, 3, '打鍵感が心地よいメカニカルキーボード。', 'タイピング作業が楽しくなる。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(39, 'G0039', 'ITEM-039', 'PCモニター 24インチ', 'sample_39.jpg', 18000, 10, 10, 3, 'フルHD対応の24インチモニター。', 'テレワークや動画視聴に。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(40, 'G0040', 'ITEM-040', 'USBメモリ 64GB', 'sample_40.jpg', 1200, 10, 100, 3, '高速転送対応のUSB3.0メモリ。', 'データの持ち運びに便利。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(41, 'G0041', 'ITEM-041', 'ボールペン 高級', 'sample_41.jpg', 5000, 10, 30, 3, '書き味滑らかな高級ボールペン。', 'ビジネスシーンで活躍。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(42, 'G0042', 'ITEM-042', 'システム手帳 革', 'sample_42.jpg', 7800, 10, 20, 3, '使いやすいA5サイズのシステム手帳。', 'スケジュール管理をスマートに。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(43, 'G0043', 'ITEM-043', '名刺入れ', 'sample_43.jpg', 3500, 10, 40, 3, 'シンプルなデザインの名刺入れ。', '第一印象を良くするアイテム。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(44, 'G0044', 'ITEM-044', 'ネクタイ ドット柄', 'sample_44.jpg', 4500, 10, 35, 3, 'シルク100%の上質なネクタイ。', 'Vゾーンを華やかに演出。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(45, 'G0045', 'ITEM-045', 'ワイシャツ 白', 'sample_45.jpg', 3900, 10, 50, 1, '形態安定加工のワイシャツ。', 'アイロンがけが楽で毎日使いやすい。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(46, 'G0046', 'ITEM-046', 'スーツケース 機内持ち込み', 'sample_46.jpg', 15000, 10, 10, 3, '軽量で丈夫なスーツケース。', '1〜2泊の旅行や出張に。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(47, 'G0047', 'ITEM-047', 'トラベルポーチ セット', 'sample_47.jpg', 2000, 10, 60, 3, '荷物を整理しやすいポーチ6点セット。', 'パッキングが快適に。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(48, 'G0048', 'ITEM-048', 'ネックピロー', 'sample_48.jpg', 1800, 10, 40, 3, '低反発素材のネックピロー。', '長時間の移動も快適に。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25'),
(49, 'G0049', 'ITEM-049', 'アイマスク', 'sample_49.jpg', 1000, 10, 80, 3, '遮光性の高いアイマスク。', '質の高い睡眠をサポート。', 1, 0, '2025-11-23 21:00:25', NULL, '2025-11-23 12:00:25', '2025-11-23 12:00:25');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_orders`
--

CREATE TABLE `t_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(30) NOT NULL COMMENT '注文番号',
  `total_price` decimal(10,0) NOT NULL COMMENT '合計金額',
  `shipping_fee` decimal(10,0) NOT NULL COMMENT '送料',
  `status_id` bigint(20) UNSIGNED NOT NULL COMMENT 'ステータスID',
  `payment_id` bigint(20) UNSIGNED NOT NULL COMMENT '支払方法ID',
  `shipping_name` varchar(255) NOT NULL COMMENT '配送先宛名(履歴)',
  `shipping_address` text NOT NULL COMMENT '配送先住所(履歴)',
  `ordered_at` datetime NOT NULL COMMENT '注文日時',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_payment_intent_id` varchar(255) DEFAULT NULL COMMENT 'Stripe PaymentIntent ID',
  `stripe_charge_id` varchar(255) DEFAULT NULL COMMENT 'Stripe Charge ID',
  `payment_status` tinyint(4) DEFAULT 0 COMMENT '0:未決済, 1:決済完了, 2:決済失敗, 3:返金済み',
  `payment_error_message` text DEFAULT NULL COMMENT '決済エラーメッセージ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `t_orders`
--

INSERT INTO `t_orders` (`id`, `user_id`, `order_number`, `total_price`, `shipping_fee`, `status_id`, `payment_id`, `shipping_name`, `shipping_address`, `ordered_at`, `created_at`, `updated_at`, `stripe_payment_intent_id`, `stripe_charge_id`, `payment_status`, `payment_error_message`) VALUES
(1, 3, 'ORD-20251129-DAC45DC0', '17500', '0', 2, 1, 'テスト', '〒111-1111 大分県無市夢夢無１１１番地1', '2025-11-29 00:20:12', '2025-11-28 15:20:12', '2025-11-28 15:20:12', NULL, NULL, 0, NULL),
(2, 3, 'ORD-20251129-E42BE6EF', '39500', '0', 1, 2, 'テスト', '〒111-1111 大分県無市夢夢無１１１番地1', '2025-11-29 00:22:42', '2025-11-28 15:22:42', '2025-11-28 15:22:42', NULL, NULL, 0, NULL),
(3, 3, 'ORD-20251129-0C47D842', '3500', '500', 2, 1, 'テスト', '〒111-1111 大分県無市夢夢無１１１番地1', '2025-11-29 00:33:24', '2025-11-28 15:33:24', '2025-11-28 15:33:24', NULL, NULL, 0, NULL),
(4, 3, 'ORD-20251129-7B475820', '12800', '0', 1, 3, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-11-29 20:23:32', '2025-11-29 11:23:32', '2025-11-29 11:23:32', NULL, NULL, 0, NULL),
(5, 3, 'ORD-20251130-EAC8EFC6', '45400', '0', 2, 1, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-11-30 20:46:52', '2025-11-30 11:46:52', '2025-11-30 11:46:57', 'pi_3SZ95dPE3IinzQzF0Aqr3SzC', NULL, 1, NULL),
(6, 3, 'ORD-20251130-659C690E', '3500', '500', 2, 1, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-11-30 22:27:53', '2025-11-30 13:27:53', '2025-11-30 13:27:56', 'pi_3SZAfOPE3IinzQzF0XX24pXa', NULL, 1, NULL),
(7, 3, 'ORD-20251203-0D23E337', '54500', '0', 2, 1, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-12-03 21:45:06', '2025-12-03 12:45:06', '2025-12-03 12:45:10', 'pi_3SaFQdPE3IinzQzF21JRoZEW', NULL, 1, NULL),
(8, 3, 'ORD-20251203-0D6D605B', '54500', '0', 2, 1, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-12-03 21:45:10', '2025-12-03 12:45:10', '2025-12-03 12:45:11', 'pi_3SaFQhPE3IinzQzF0Pk9x169', NULL, 1, NULL),
(9, 3, 'ORD-20251203-B0FDAE9D', '3500', '500', 1, 2, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-12-03 22:28:47', '2025-12-03 13:28:47', '2025-12-03 13:28:47', NULL, NULL, 0, NULL),
(10, 3, 'ORD-20251203-B5864C88', '16300', '0', 10, 3, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-12-03 22:30:00', '2025-12-03 13:30:00', '2025-12-03 13:30:00', NULL, NULL, 0, NULL),
(11, 3, 'ORD-20251203-0768ED0F', '12800', '0', 9, 1, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-12-03 22:51:50', '2025-12-03 13:51:50', '2025-12-03 13:51:53', 'pi_3SaGTDPE3IinzQzF04AQq0Cu', NULL, 1, NULL),
(12, 3, 'ORD-20251203-7583AAD8', '7000', '500', 9, 1, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-12-03 23:21:12', '2025-12-03 14:21:12', '2025-12-03 14:21:12', 'pi_3SaGvcPE3IinzQzF1zlQWpCK', NULL, 0, NULL),
(13, 3, 'ORD-20251203-7FA90595', '27800', '0', 9, 1, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-12-03 23:23:54', '2025-12-03 14:23:54', '2025-12-03 14:23:55', 'pi_3SaGyEPE3IinzQzF28gKr9I0', NULL, 0, NULL),
(14, 3, 'ORD-20251204-107B8EA1', '3500', '500', 9, 1, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-12-04 00:02:31', '2025-12-03 15:02:31', '2025-12-03 15:02:32', 'pi_3SaHZbPE3IinzQzF2yHT5P5O', NULL, 0, NULL),
(15, 3, 'ORD-20251204-47CAC0DD', '1800', '500', 9, 1, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-12-04 00:17:16', '2025-12-03 15:17:16', '2025-12-03 15:17:17', 'pi_3SaHnsPE3IinzQzF2om2PMDl', NULL, 0, NULL),
(16, 3, 'ORD-20251204-DCBC55A0', '16300', '0', 9, 1, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-12-04 20:17:31', '2025-12-04 11:17:31', '2025-12-04 11:17:32', 'pi_3SaaXQPE3IinzQzF12yhn7F3', NULL, 0, NULL),
(17, 3, 'ORD-20251204-EFD1C1BD', '3500', '500', 2, 1, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-12-04 20:22:37', '2025-12-04 11:22:37', '2025-12-04 11:22:37', NULL, NULL, 0, NULL),
(18, 3, 'ORD-20251204-2846BA28', '3500', '500', 2, 1, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-12-04 20:37:40', '2025-12-04 11:37:40', '2025-12-04 11:37:40', NULL, NULL, 0, NULL),
(19, 3, 'ORD-20251204-556BFC91', '8900', '500', 2, 1, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-12-04 20:49:42', '2025-12-04 11:49:42', '2025-12-04 11:49:42', NULL, NULL, 0, NULL),
(20, 3, 'ORD-20251204-6EF86676', '3500', '500', 2, 1, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-12-04 20:56:31', '2025-12-04 11:56:31', '2025-12-04 11:56:31', NULL, NULL, 0, NULL),
(21, 3, 'ORD-20251204-84FB25D1', '12800', '0', 2, 1, 'テスト（注文確認で追加）', '〒222-1111 島根県島根市島根番地3', '2025-12-04 21:02:23', '2025-12-04 12:02:23', '2025-12-04 12:02:23', NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `t_order_details`
--

CREATE TABLE `t_order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `goods_id` bigint(20) UNSIGNED NOT NULL,
  `goods_name` varchar(255) NOT NULL COMMENT '商品名(履歴)',
  `price` decimal(10,0) NOT NULL COMMENT '購入単価',
  `quantity` int(11) NOT NULL COMMENT '数量',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `t_order_details`
--

INSERT INTO `t_order_details` (`id`, `order_id`, `goods_id`, `goods_name`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'クラシックロゴTシャツ ホワイト', '3500', 3, '2025-11-28 15:20:12', '2025-11-28 15:20:12'),
(2, 1, 2, 'クラシックロゴTシャツ ブラック', '3500', 2, '2025-11-28 15:20:12', '2025-11-28 15:20:12'),
(3, 2, 3, 'ヴィンテージデニムパンツ', '12800', 1, '2025-11-28 15:22:42', '2025-11-28 15:22:42'),
(4, 2, 4, 'スリムフィットチノパン ベージュ', '8900', 3, '2025-11-28 15:22:42', '2025-11-28 15:22:42'),
(5, 3, 2, 'クラシックロゴTシャツ ブラック', '3500', 1, '2025-11-28 15:33:24', '2025-11-28 15:33:24'),
(6, 4, 3, 'ヴィンテージデニムパンツ', '12800', 1, '2025-11-29 11:23:32', '2025-11-29 11:23:32'),
(7, 5, 1, 'クラシックロゴTシャツ ホワイト', '3500', 1, '2025-11-30 11:46:52', '2025-11-30 11:46:52'),
(8, 5, 2, 'クラシックロゴTシャツ ブラック', '3500', 1, '2025-11-30 11:46:52', '2025-11-30 11:46:52'),
(9, 5, 3, 'ヴィンテージデニムパンツ', '12800', 3, '2025-11-30 11:46:52', '2025-11-30 11:46:52'),
(10, 6, 2, 'クラシックロゴTシャツ ブラック', '3500', 1, '2025-11-30 13:27:53', '2025-11-30 13:27:53'),
(11, 7, 6, 'レザーショルダーバッグ', '15000', 1, '2025-12-03 12:45:06', '2025-12-03 12:45:06'),
(12, 7, 3, 'ヴィンテージデニムパンツ', '12800', 1, '2025-12-03 12:45:06', '2025-12-03 12:45:06'),
(13, 7, 4, 'スリムフィットチノパン ベージュ', '8900', 3, '2025-12-03 12:45:06', '2025-12-03 12:45:06'),
(14, 8, 6, 'レザーショルダーバッグ', '15000', 1, '2025-12-03 12:45:10', '2025-12-03 12:45:10'),
(15, 8, 3, 'ヴィンテージデニムパンツ', '12800', 1, '2025-12-03 12:45:10', '2025-12-03 12:45:10'),
(16, 8, 4, 'スリムフィットチノパン ベージュ', '8900', 3, '2025-12-03 12:45:10', '2025-12-03 12:45:10'),
(17, 9, 2, 'クラシックロゴTシャツ ブラック', '3500', 1, '2025-12-03 13:28:47', '2025-12-03 13:28:47'),
(18, 10, 2, 'クラシックロゴTシャツ ブラック', '3500', 1, '2025-12-03 13:30:00', '2025-12-03 13:30:00'),
(19, 10, 3, 'ヴィンテージデニムパンツ', '12800', 1, '2025-12-03 13:30:00', '2025-12-03 13:30:00'),
(20, 11, 3, 'ヴィンテージデニムパンツ', '12800', 1, '2025-12-03 13:51:50', '2025-12-03 13:51:50'),
(21, 12, 1, 'クラシックロゴTシャツ ホワイト', '3500', 2, '2025-12-03 14:21:12', '2025-12-03 14:21:12'),
(22, 13, 6, 'レザーショルダーバッグ', '15000', 1, '2025-12-03 14:23:54', '2025-12-03 14:23:54'),
(23, 13, 3, 'ヴィンテージデニムパンツ', '12800', 1, '2025-12-03 14:23:54', '2025-12-03 14:23:54'),
(24, 14, 2, 'クラシックロゴTシャツ ブラック', '3500', 1, '2025-12-03 15:02:31', '2025-12-03 15:02:31'),
(25, 15, 10, 'ニットキャップ ネイビー', '1800', 1, '2025-12-03 15:17:16', '2025-12-03 15:17:16'),
(26, 16, 2, 'クラシックロゴTシャツ ブラック', '3500', 1, '2025-12-04 11:17:31', '2025-12-04 11:17:31'),
(27, 16, 3, 'ヴィンテージデニムパンツ', '12800', 1, '2025-12-04 11:17:31', '2025-12-04 11:17:31'),
(28, 17, 1, 'クラシックロゴTシャツ ホワイト', '3500', 1, '2025-12-04 11:22:37', '2025-12-04 11:22:37'),
(29, 18, 2, 'クラシックロゴTシャツ ブラック', '3500', 1, '2025-12-04 11:37:40', '2025-12-04 11:37:40'),
(30, 19, 4, 'スリムフィットチノパン ベージュ', '8900', 1, '2025-12-04 11:49:42', '2025-12-04 11:49:42'),
(31, 20, 2, 'クラシックロゴTシャツ ブラック', '3500', 1, '2025-12-04 11:56:31', '2025-12-04 11:56:31'),
(32, 21, 3, 'ヴィンテージデニムパンツ', '12800', 1, '2025-12-04 12:02:23', '2025-12-04 12:02:23');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_shipping_addresses`
--

CREATE TABLE `t_shipping_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'ユーザーID',
  `name` varchar(255) NOT NULL COMMENT '宛名',
  `postal_code` varchar(8) NOT NULL COMMENT '郵便番号',
  `prefecture_id` bigint(20) UNSIGNED NOT NULL COMMENT '都道府県ID',
  `city` varchar(255) NOT NULL COMMENT '市区町村',
  `address_line` varchar(255) NOT NULL COMMENT '番地・建物',
  `phone` varchar(20) NOT NULL COMMENT '電話番号',
  `is_default` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'デフォルトフラグ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `t_shipping_addresses`
--

INSERT INTO `t_shipping_addresses` (`id`, `user_id`, `name`, `postal_code`, `prefecture_id`, `city`, `address_line`, `phone`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 3, 'テスト', '111-1111', 44, '無市夢夢無１１１', '番地1', '01011111111', 0, '2025-11-28 15:19:12', '2025-11-29 11:22:07'),
(2, 3, 'テスト（注文確認で追加）', '222-1111', 32, '島根市島根', '番地3', '1111222', 1, '2025-11-29 11:22:07', '2025-11-29 11:22:07');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL COMMENT '電話番号',
  `birthday` date DEFAULT NULL COMMENT '生年月日',
  `gender` tinyint(4) DEFAULT NULL COMMENT '性別(1:男,2:女,9:その他)',
  `is_admin` tinyint(1) NOT NULL DEFAULT 0 COMMENT '管理者フラグ',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '会員ステータス(1:通常,2:退会)',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `delete_flg` tinyint(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ 0:有効 1:削除済み'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `birthday`, `gender`, `is_admin`, `status`, `remember_token`, `created_at`, `updated_at`, `delete_flg`) VALUES
(3, 'youtaishi754', 'youtaishi754@gmail.com', NULL, '$2y$10$ks.DEH3QzyUH4Jz6ugynAOqHxotQudqMv3n5hAZ3YK4fampFryrD.', NULL, NULL, NULL, 0, 1, NULL, '2025-11-24 14:46:04', '2025-11-24 14:46:04', 0);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `m_order_statuses`
--
ALTER TABLE `m_order_statuses`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `m_payment_methods`
--
ALTER TABLE `m_payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `m_prefectures`
--
ALTER TABLE `m_prefectures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `m_prefectures_code_unique` (`code`);

--
-- テーブルのインデックス `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- テーブルのインデックス `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- テーブルのインデックス `pre_registrations`
--
ALTER TABLE `pre_registrations`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `t_favorites`
--
ALTER TABLE `t_favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `t_favorites_user_id_goods_id_unique` (`user_id`,`goods_id`),
  ADD KEY `t_favorites_goods_id_foreign` (`goods_id`);

--
-- テーブルのインデックス `t_goods`
--
ALTER TABLE `t_goods`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `t_orders`
--
ALTER TABLE `t_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `t_orders_order_number_unique` (`order_number`),
  ADD KEY `t_orders_user_id_foreign` (`user_id`);

--
-- テーブルのインデックス `t_order_details`
--
ALTER TABLE `t_order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_order_details_order_id_foreign` (`order_id`),
  ADD KEY `t_order_details_goods_id_foreign` (`goods_id`);

--
-- テーブルのインデックス `t_shipping_addresses`
--
ALTER TABLE `t_shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_shipping_addresses_user_id_foreign` (`user_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルのAUTO_INCREMENT `m_order_statuses`
--
ALTER TABLE `m_order_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- テーブルのAUTO_INCREMENT `m_payment_methods`
--
ALTER TABLE `m_payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルのAUTO_INCREMENT `m_prefectures`
--
ALTER TABLE `m_prefectures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- テーブルのAUTO_INCREMENT `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルのAUTO_INCREMENT `pre_registrations`
--
ALTER TABLE `pre_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルのAUTO_INCREMENT `t_favorites`
--
ALTER TABLE `t_favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルのAUTO_INCREMENT `t_goods`
--
ALTER TABLE `t_goods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- テーブルのAUTO_INCREMENT `t_orders`
--
ALTER TABLE `t_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- テーブルのAUTO_INCREMENT `t_order_details`
--
ALTER TABLE `t_order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- テーブルのAUTO_INCREMENT `t_shipping_addresses`
--
ALTER TABLE `t_shipping_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルのAUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD CONSTRAINT `payment_logs_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `t_orders` (`id`);

--
-- テーブルの制約 `t_favorites`
--
ALTER TABLE `t_favorites`
  ADD CONSTRAINT `t_favorites_goods_id_foreign` FOREIGN KEY (`goods_id`) REFERENCES `t_goods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `t_orders`
--
ALTER TABLE `t_orders`
  ADD CONSTRAINT `t_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- テーブルの制約 `t_order_details`
--
ALTER TABLE `t_order_details`
  ADD CONSTRAINT `t_order_details_goods_id_foreign` FOREIGN KEY (`goods_id`) REFERENCES `t_goods` (`id`),
  ADD CONSTRAINT `t_order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `t_orders` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `t_shipping_addresses`
--
ALTER TABLE `t_shipping_addresses`
  ADD CONSTRAINT `t_shipping_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
