CREATE DATABASE IF NOT EXISTS yk_eggs CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE yk_eggs;

CREATE TABLE IF NOT EXISTS calculations (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  customer VARCHAR(255) DEFAULT 'Walk-in',
  region VARCHAR(100) NOT NULL,
  trays INT UNSIGNED NOT NULL,
  eggs_per_tray INT UNSIGNED NOT NULL DEFAULT 30,
  cost_per_tray DECIMAL(12,2) NOT NULL,
  sell_per_tray DECIMAL(12,2) NOT NULL,
  transport DECIMAL(12,2) NOT NULL DEFAULT 0,
  other_costs DECIMAL(12,2) NOT NULL DEFAULT 0,
  total_eggs INT UNSIGNED NOT NULL,
  revenue DECIMAL(14,2) NOT NULL,
  total_cost DECIMAL(14,2) NOT NULL,
  profit DECIMAL(14,2) NOT NULL,
  margin DECIMAL(8,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_region(region),
  INDEX idx_created_at(created_at)
);

CREATE TABLE IF NOT EXISTS regions (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE,
  active BOOLEAN NOT NULL DEFAULT TRUE
);

INSERT IGNORE INTO regions(name) VALUES
('Kampala'),('Entebbe'),('Wakiso'),('Jinja'),('Mukono'),('Other');
