-- CampusFix schema for Laragon / MySQL 8+
-- Import this file in HeidiSQL or the Laragon database client.
CREATE DATABASE IF NOT EXISTS campusfix
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE campusfix;
SET NAMES utf8mb4;
CREATE TABLE IF NOT EXISTS migrations (
  id bigint unsigned NOT NULL AUTO_INCREMENT,
  migration varchar(255) NOT NULL,
  batch int NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS users (
  id bigint unsigned NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  role varchar(20) NOT NULL DEFAULT 'student',
  email_verified_at timestamp NULL DEFAULT NULL,
  password varchar(255) NOT NULL,
  remember_token varchar(100) DEFAULT NULL,
  created_at timestamp NULL DEFAULT NULL,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY users_email_unique (email),
  KEY users_role_index (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS password_reset_tokens (
  email varchar(255) NOT NULL,
  token varchar(255) NOT NULL,
  created_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS sessions (
  id varchar(255) NOT NULL,
  user_id bigint unsigned DEFAULT NULL,
  ip_address varchar(45) DEFAULT NULL,
  user_agent text,
  payload longtext NOT NULL,
  last_activity int NOT NULL,
  PRIMARY KEY (id),
  KEY sessions_user_id_index (user_id),
  KEY sessions_last_activity_index (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS facility_concerns (
  id bigint unsigned NOT NULL AUTO_INCREMENT,
  user_id bigint unsigned NOT NULL,
  reviewed_by bigint unsigned DEFAULT NULL,
  reference_code varchar(40) DEFAULT NULL,
  category varchar(50) NOT NULL,
  location varchar(255) NOT NULL,
  description text NOT NULL,
  photo_path varchar(255) DEFAULT NULL,
  status varchar(20) NOT NULL DEFAULT 'pending',
  admin_note text,
  created_at timestamp NULL DEFAULT NULL,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY facility_concerns_reference_code_unique (reference_code),
  KEY facility_concerns_category_index (category),
  KEY facility_concerns_status_index (status),
  KEY facility_concerns_user_id_created_at_index (user_id, created_at),
  KEY facility_concerns_reviewed_by_foreign (reviewed_by),
  CONSTRAINT facility_concerns_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
  CONSTRAINT facility_concerns_reviewed_by_foreign_key FOREIGN KEY (reviewed_by) REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO migrations (migration, batch) VALUES
  ('0001_01_01_000000_create_users_table', 1),
  ('2026_11_23_000001_create_facility_concerns_table', 1);

INSERT IGNORE INTO users (name, email, role, password, created_at, updated_at) VALUES
  ('CampusFix Administrator', 'admin@campusfix.test', 'admin', '$2y$12$2fzjLQQ/E/pgfBW33wSZ8OqsXejF/q1GJzmG/QuyX/S/cUY9pkfeS', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
