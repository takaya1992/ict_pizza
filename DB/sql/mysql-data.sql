-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- ホスト: localhost
-- 生成日時: 2013 年 12 月 15 日 13:25
-- サーバのバージョン: 5.5.29
-- PHP のバージョン: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- データベース: `ICT_PIZZA`
--

--
-- テーブルのデータのダンプ `products`
--

INSERT INTO `products` (`id`, `name`, `description`) VALUES
(1, 'マルゲリータ', 'マルゲリータピザです'),
(2, 'イタリアーナ', '普通のイタリアーナです'),
(3, 'シーフードイタリアーナ', 'シーフードのイタリアーナです'),
(4, 'モントレー', 'モントレーです'),
(5, '和風ピザ', '和風のピザです。'),
(6, 'エビグラタンピザ', 'エビグラタンです。子どもに人気です');

--
-- テーブルのデータのダンプ `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `order`, `name`) VALUES
(0, 10, 'S'),
(1, 20, 'M'),
(2, 30, 'L');

--
-- テーブルのデータのダンプ `product_specifications`
--

INSERT INTO `product_specifications` (`id`, `product_id`, `size_id`, `price`) VALUES
(1, 1, 1, 1980),
(2, 1, 2, 2415),
(3, 2, 1, 2100),
(4, 2, 2, 3150),
(5, 3, 1, 2420),
(6, 3, 2, 3580),
(7, 4, 0, 1540),
(8, 4, 1, 2415),
(9, 5, 1, 2420),
(10, 5, 2, 3540),
(11, 6, 1, 2100),
(12, 6, 2, 3940);