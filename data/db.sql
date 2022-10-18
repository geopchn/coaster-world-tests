SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

INSERT INTO `address` (`id`, `street`, `zipcode`, `city`, `country`) VALUES
    (1, '100 Boulevard de l\'Europe', '1300', 'Wavre', 'be'),
(2, '2 Europa-Park-Straße', '77977', 'Rust', 'de'),
(3, NULL, '60128', 'Plailly', 'fr'),
(4, '644 Rue du Docteur Uberschlag', '65300', 'Lannemezan', 'fr'),
(5, '1 Roland-Mack-Ring', '77977', 'Rust', 'de');

INSERT INTO `coaster` (`id`, `name`, `image`, `opened_at`, `minimum_height`, `maximum_height`, `duration`, `manufacturer_id`, `park_id`) VALUES
(1, 'Kondaa', 'https://www.zoomsurlille.fr/wp-content/uploads/2021/04/walibi_belgium_2021.jpg', '2021-05-08', 130, NULL, '00:01:30', 3, 1),
(2, 'Blue Fire Megacoaster', 'https://www.europapark.de/sites/default/files/styles/wide/public/media_image/2020-10/blue_fire_megacoaster_europa-park_2.jpg?itok=DMx5Cmqn', '2009-04-04', 130, NULL, '00:01:50', 2, 2),
(3, 'Eurosat', 'https://www.europapark.de/sites/default/files/import/attraction/571/EurosatCanCanCoaster_Frankreich_Europa-Park.jpg', '2018-04-16', 120, 195, '00:03:30', 2, 2),
(4, 'Tonnerre de Zeus', 'https://www.parcasterix.fr/sites/default/files/styles/attraction_detail/public/images/attractions/haut/header-T2Z.jpg.webp?itok=yTkoUmRB', '1997-01-10', 120, NULL, '00:02:40', 4, 3),
(5, 'Dugdrob', 'https://www.europapark.de/sites/default/files/styles/wide/public/media_image/2021-09/rulantica_dugdrob.jpg?itok=a3DGzf36', '2019-11-28', 140, NULL, '00:00:30', 5, 5),
(6, 'Calamity Mine', 'https://www.walibi.be/sites/default/files/styles/1280x670/public/entertainment/2018-03/Calamity_MD01_.jpg?itok=rDT-h8va', '1992-03-20', 100, NULL, '00:04:30', 1, 1),
(15, 'Les Pirates de Batavia', 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Piraten_in_Batavia_2020.jpg/800px-Piraten_in_Batavia_2020.jpg', '1987-05-10', NULL, NULL, '00:08:30', 2, 2),
(16, 'Bob Luge', 'http://www.parc-lannemezan.com/wp-content/uploads/2014/05/Babibob.jpg', '2001-06-20', NULL, 190, '00:01:40', 4, 4),
(17, 'Pulsar', 'https://www.walibi.be/sites/default/files/styles/1280x670/public/entertainment/2018-03/kvds-20160604-204459-0016-fc300x.jpg?itok=E6y1meIJ', '2016-06-04', 120, NULL, '00:00:45', 2, 1),
(18, 'OzIris', 'https://i.ytimg.com/vi/yipZS7eW3GA/maxresdefault.jpg', '2012-04-07', 130, NULL, '00:02:20', 4, 3);

INSERT INTO `coaster_tag` (`coaster_id`, `tag_id`) VALUES
(1, 2),
(2, 2),
(2, 6),
(3, 2),
(4, 2),
(4, 5),
(5, 2),
(5, 4),
(6, 1),
(6, 3),
(15, 1),
(15, 3),
(15, 7),
(16, 3),
(17, 2),
(17, 4),
(18, 2),
(18, 6);

INSERT INTO `manufacturer` (`id`, `name`) VALUES
(1, 'Vekoma'),
(2, 'Mach Rides'),
(3, 'Intamin'),
(4, 'Bolliger & Mabillard'),
(5, 'Aquarena');

INSERT INTO `park` (`id`, `name`, `image`, `type`, `website`, `address_id`) VALUES
(1, 'Walibi Belgium', 'https://upload.wikimedia.org/wikipedia/commons/2/26/Walibi_Belgium_Entr%C3%A9e.jpg', 0, 'https://www.walibi.be/', 1),
(2, 'Europa Park', 'https://cdn.sortiraparis.com/images/80/86528/457109-europa-park-les-nouveautes-de-la-saison-2019.jpg', 0, 'https://www.europapark.de/', 2),
(3, 'Parc Astérix', 'https://media.timeout.com/images/100508729/image.jpg', 0, 'https://www.parcasterix.fr/', 3),
(4, 'Parc de la Demi-Lune', 'https://www.bigorre-mag.fr/wp-content/uploads/2019/07/parc-demi-lune-bigorre-mag-7.jpg', 2, NULL, 4),
(5, 'Rulantica', 'https://www.europapark.de/sites/default/files/media_image/2019-12/rulantica_skip_strand_europa-park.jpg', 1, 'https://www.europapark.de/rulantica', 5);

INSERT INTO `tag` (`id`, `name`) VALUES
(1, 'Famille'),
(2, 'Sensation'),
(3, 'Junior'),
(4, 'Aquatique'),
(5, 'Bois'),
(6, 'Inversion'),
(7, 'Scénique');
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
