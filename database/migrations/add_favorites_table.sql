-- お気に入りテーブルの作成
CREATE TABLE IF NOT EXISTS `favorites` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL COMMENT 'ユーザーID',
  `goods_id` BIGINT UNSIGNED NOT NULL COMMENT '商品ID',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `favorites_user_goods_unique` (`user_id`, `goods_id`),
  KEY `favorites_user_id_index` (`user_id`),
  KEY `favorites_goods_id_index` (`goods_id`),
  CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favorites_goods_id_foreign` FOREIGN KEY (`goods_id`) REFERENCES `t_goods` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='お気に入り';
