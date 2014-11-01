# Dump of table posts
# ------------------------------------------------------------

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(64) NOT NULL DEFAULT '',
  `title` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

# Dump of table comments
# ------------------------------------------------------------

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_post_id_index` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



