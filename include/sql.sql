CREATE TABLE `Content` (
  `id` int(11) NOT NULL auto_increment,
  `titleTag` varchar(255) NOT NULL default '',
  `metaDescription` varchar(255) NOT NULL default '',
  `metaKeywords` varchar(255) NOT NULL default '',
  `stylesheet` varchar(80) NOT NULL default '',
  `content` longtext NOT NULL,
  `seoPageName` varchar(255) NOT NULL default '',
  `pageName` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `User` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(80) NOT NULL default '',
  `password` varchar(160) NOT NULL default '',
  `admin` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `Menu` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(80) NOT NULL default '',
  `orderNum` int(11) NOT NULL default '0',
  `href` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `Menu_Item` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(80) NOT NULL default '',
  `menuID` int(11) NOT NULL default '0',
  `pageID` int(11) NOT NULL default '0',
  `orderNum` int(11) NOT NULL default '0',
  `isHeader` int(11) NOT NULL default '0',
  `href` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `Permission` (
  `id` int(11) NOT NULL auto_increment,
  `contentID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `Revision_Log` (
  `id` int(11) NOT NULL auto_increment,
  `contentID` int(11) NOT NULL default '0',
  `revisionDateTime` datetime NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `contentID` (`contentID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `Config` (
  `id` int(11) NOT NULL auto_increment,
  `key` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
