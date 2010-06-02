CREATE TABLE IF NOT EXISTS `connection_info` (`id` int(255) NOT NULL AUTO_INCREMENT,`host` text NOT NULL,`port` varchar(255) NOT NULL,`password` varchar(255) NOT NULL,`user` varchar(255) NOT NULL,`ip` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `dj_says` (`id` int(255) NOT NULL AUTO_INCREMENT,`message` text NOT NULL,`author` varchar(255) NOT NULL,`ip` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `events` (`id` int(255) NOT NULL AUTO_INCREMENT,`name` text NOT NULL,`day` varchar(255) NOT NULL,`time` varchar(255) NOT NULL,`hotel` varchar(255) NOT NULL,`host` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `menu` (`id` int(255) NOT NULL AUTO_INCREMENT,`text` text NOT NULL,`url` varchar(255) NOT NULL,`resource` varchar(255) NOT NULL,`usergroup` varchar(255) NOT NULL,`protected` varchar(255) NOT NULL,`weight` int(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `mgmt_messages` (`id` int(255) NOT NULL AUTO_INCREMENT,`message` varchar(255) NOT NULL,`user` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `news` (`id` int(255) NOT NULL AUTO_INCREMENT,`category` varchar(255) NOT NULL,`title` text NOT NULL,`desc` text NOT NULL,`article` text NOT NULL,`author` varchar(255) NOT NULL,`stamp` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `news_categories` (`id` int(255) NOT NULL AUTO_INCREMENT,`name` text NOT NULL,`admin` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `requests` (`id` int(255) NOT NULL AUTO_INCREMENT,`type` varchar(255) NOT NULL,`for` varchar(255) NOT NULL,`author` varchar(255) NOT NULL,`message` text NOT NULL,`stamp` varchar(255) NOT NULL,`ip` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `request_types` (`id` int(255) NOT NULL AUTO_INCREMENT,`name` varchar(255) NOT NULL,`colour` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `sessions` (`id` int(255) NOT NULL AUTO_INCREMENT,`session_id` varchar(255) NOT NULL,`user_id` varchar(255) NOT NULL,`stamp` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `site_alerts` (`id` int(255) NOT NULL AUTO_INCREMENT,`message` text NOT NULL,`author` varchar(255) NOT NULL,`time` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `timetable` (`id` int(255) NOT NULL AUTO_INCREMENT,`day` varchar(255) NOT NULL,`time` varchar(255) NOT NULL,`dj` varchar(255) NOT NULL,`perm` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `usergroups` (`id` int(255) NOT NULL AUTO_INCREMENT,`name` varchar(255) NOT NULL,`colour` varchar(255) NOT NULL,`weight` int(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `users` (`id` int(255) NOT NULL AUTO_INCREMENT,`username` varchar(255) NOT NULL,`password` varchar(255) NOT NULL,`email` varchar(255) NOT NULL,`habbo` varchar(255) NOT NULL,`displaygroup` varchar(255) NOT NULL,`usergroups` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



INSERT INTO `menu` (`id`, `text`, `url`, `resource`, `usergroup`, `protected`, `weight`) VALUES (1, 'Add menu item', 'admin.addMenu', '_res/admin/addMenu.php', '5', '1', 1), (2, 'Manage menu items', 'admin.manageMenus', '_res/admin/manageMenus.php', '5', '1', 2), (3, 'Home', 'core.home', '_res/core/home.php', '1', '1', -6), (4, 'Panel rules', 'core.panelRules', '_res/core/panelRules.php', '1', '0', 2), (5, 'Change password', 'core.changePassword', '_res/core/changePassword.php', '1', '0', 3), (6, 'Change email', 'core.changeEmail', '_res/core/changeEmail.php', '1', '0', 4), (7, 'Change Habbo', 'core.changeHabbo', '_res/core/changeHabbo.php', '1', '0', 5), (8, 'View staff emails', 'core.staffEmails', '_res/core/staffEmails.php', '1', '0', 6), (9, 'Send message to management', 'core.mgmtMessage', '_res/core/mgmtMessage.php', '1', '0', 7), (10, 'Log out', 'core.logout', '_res/core/logout.php', '1', '0', 8), (11, 'View requests', 'radio.requests', '_res/radio/requests.php', '2', '0', 1), (12, 'Set DJ says', 'radio.djSays', '_res/radio/djSays.php', '2', '0', 2), (13, 'Book timetable slot', 'radio.timetable', '_res/radio/timetable.php', '2', '0', 3), (14, 'View connection information', 'radio.connection', '_res/radio/connection.php', '2', '0', 4), (17, 'Add news', 'news.add', '_res/news/add.php', '3', '0', 1), (18, 'Manage news', 'news.manage', '_res/news/manage.php', '3', '0', 2), (20, 'Add panel user', 'mgmt.addUser', '_res/mgmt/addUser.php', '4', '0', 1), (21, 'Manage panel users', 'mgmt.manageUsers', '_res/mgmt/manageUsers.php', '4', '0', 2), (22, 'Add news category', 'mgmt.addNewsCat', '_res/mgmt/addNewsCat.php', '4', '0', 3), (23, 'Manage news categories', 'mgmt.manageNewsCat', '_res/mgmt/manageNewsCat.php', '4', '0', 4), (24, 'Add event', 'mgmt.addEvent', '_res/mgmt/addEvent.php', '4', '0', 5), (25, 'Manage events', 'mgmt.manageEvents', '_res/mgmt/manageEvents.php', '4', '0', 6), (28, 'Alert website', 'mgmt.siteAlert', '_res/mgmt/siteAlert.php', '4', '0', 15), (30, 'Change connection information', 'mgmt.changeConnection', '_res/mgmt/changeConnection.php', '4', '0', 17), (31, 'View user messages', 'mgmt.viewMessages', '_res/mgmt/viewMessages.php', '4', '0', 18), (33, 'Add usergroup', 'admin.addUsergroup', '_res/admin/addUsergroup.php', '5', '0', 3), (34, 'Manage usergroup', 'admin.manageUsergroups', '_res/admin/manageUsergroups.php', '5', '0', 4), (37, 'Add permanent show', 'mgmt.addPermShow', '_res/mgmt/addPermShow.php', '4', '0', 11), (38, 'Manage permanent shows', 'mgmt.managePermShows', '_res/mgmt/managePermShows.php', '4', '0', 12), (39, 'Add request type', 'mgmt.addRequestType', '_res/mgmt/addRequestType.php', '4', '0', 13), (40, 'Manage request types', 'mgmt.manageRequestTypes', '_res/mgmt/manageRequestTypes.php', '4', '0', 14);


INSERT INTO `news_categories` (`id`, `name`, `admin`) VALUES (1, 'Site News', '1'), (2, 'Habbo UK', '0'), (3, 'Habbo US', '0'), (4, 'Habbo CA', '0'), (5, 'Habbo AU', '0'), (6, 'Real Life', '0');


INSERT INTO `request_types` (`id`, `name`, `colour`) VALUES (1, 'Request', 'cc0000'), (2, 'Shoutout', 'ff6600'), (3, 'Joke', 'aa00ff'), (4, 'Competition', '00cc00');


INSERT INTO `usergroups` (`id`, `name`, `colour`, `weight`) VALUES (5, 'Administrator', 'ee0000', 5), (1, 'User', '333333', 1), (2, 'Radio DJ', '3E6791', 2), (3, 'News', '009988', 3), (4, 'Management', '33AA00', 4);
