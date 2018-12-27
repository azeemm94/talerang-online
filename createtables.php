<?php
$sql="CREATE TABLE IF NOT EXISTS `activemockroom` (
        `id`            int(5)         NOT NULL AUTO_INCREMENT,
        `counsellor`    varchar(200)   NOT NULL,
        `cemail`        varchar(255)   NOT NULL,
        `student`       varchar(200)   NOT NULL,
        `semail`        varchar(255)   NOT NULL,
        `timeactivated` varchar(50)    NOT NULL,
        `roomid`        varchar(50)    NOT NULL,
        `roomname`      varchar(50)    NOT NULL,
        `active`        boolean        NOT NULL,
        `hash`          varchar(50)    NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `adminpass` (
		  `id`        int    (5)   NOT NULL AUTO_INCREMENT,
		  `email`     varchar(250) NOT NULL,
		  `password`  varchar(100) NOT NULL,
		  `privilege` int    (1)   NOT NULL,
		  `hash`      varchar(100) NOT NULL,
		  `settime`   varchar(30)  NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `couponcodes`(
    	`id` int(10) NOT NULL AUTO_INCREMENT,
    	`code` varchar(6) NOT NULL,
    	`email` varchar(254),
    	`used` tinyint(1) NOT NULL,
    	`date` varchar(25),
    	PRIMARY KEY (`id`)
    	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `feedback`(
		`id`      int     (10) NOT NULL AUTO_INCREMENT,
		`hash`    varchar (50) NOT NULL,
		`rating`  varchar (20) NOT NULL,
		`comment` text,
		`time`    varchar (30) NOT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `feespaid`(
	    `id`              int(10)      NOT NULL AUTO_INCREMENT,
	    `accountno`       varchar(11)  NOT NULL,
	    `firstname`       varchar(20)  NOT NULL,
	    `lastname`        varchar(20)  NOT NULL,
	    `email`           varchar(60)  NOT NULL,
	    `status`          varchar(10)  NOT NULL,
	    `transactionid`   varchar(50)  NOT NULL,
	    `amount`          varchar(10)  NOT NULL,
	    `paymenttime`     varchar(21)  NOT NULL,
	    `emailcitrus`     varchar(60)  NOT NULL,
	    `mobilecitrus`    varchar(15)  NOT NULL,
	    `type`            varchar(20)  NOT NULL,
	    PRIMARY KEY (`id`)
	    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `fileupload` (
		`id` int( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`accountno`  varchar(10)  NOT NULL,
		`filename`   varchar(500) NOT NULL,
		`uploadtype` varchar(50)  NOT NULL,
		`uploadtime` varchar(50)  NOT NULL		
		) ENGINE = INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `forgotpass`(
		`id`     int(10)     NOT NULL AUTO_INCREMENT,
		`email`  varchar(60) NOT NULL,
		`hash`   varchar(40) NOT NULL,
		`requesttime` varchar(30) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `genz` (
		  `id`        int    (10)  NOT NULL AUTO_INCREMENT,
		  `quizid`    varchar(15)  NOT NULL,
		  `email`     varchar(255) NOT NULL,
		  `fullname`  varchar(200) NOT NULL,
		  `answers`   varchar(15)  NOT NULL,
		  `score`     int    (3)   NOT NULL,
		  `starttime` varchar(40)  NOT NULL,
		  `endtime`   varchar(40)  NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `industryfiles` (
		`id`    int    (10)  NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`email` varchar(255) NOT NULL,
		`name`  varchar(200) NOT NULL,
		`type`  varchar(40)  NOT NULL,
		`link`  varchar(400) NOT NULL,
		`date`  varchar(40)  NOT NULL
		) ENGINE = INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `jhe`(
		`id` 	   int(10)      NOT NULL AUTO_INCREMENT,
		`quizid`   varchar(15)  NOT NULL,
		`email`    varchar(256) NOT NULL,
		`fullname` varchar(400) NOT NULL,
		`answers`  varchar(11)  NOT NULL,
		`j`        int(3)       NOT NULL,
		`h`        int(3)       NOT NULL,
		`e`        int(3)       NOT NULL,
		`outcome`  varchar(50)  NOT NULL,
		`starttime`varchar(100) NOT NULL,
		`endtime`  varchar(100) NOT NULL,
		PRIMARY KEY (`id`)
		)  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";	

$sql.="CREATE TABLE IF NOT EXISTS `mockfeedback`(
	    `id`              int(10)      NOT NULL AUTO_INCREMENT,
	    `fullname`        varchar(50)  NOT NULL,
	    `email`           varchar(60)  NOT NULL,
	    `intdate`         varchar(30)  NOT NULL,
	    `inttype`         varchar(10)  NOT NULL,
	    `mockfeedback`    text         NOT NULL,
	    `emailed`         tinyint(1) ,
	    PRIMARY KEY (`id`)
	    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `mockinterviews`(
		`id`          int(10) AUTO_INCREMENT NOT NULL,
		`accountno`   varchar(11) NOT NULL,
		`fullname`    varchar(50) NOT NULL,
		`email`       varchar(60) NOT NULL,
		`track`       text        NOT NULL,
		`type`        varchar(10) NOT NULL,
		`grade10`     varchar(40) NOT NULL,
		`grade12`     varchar(40) NOT NULL,
		`lship`       text        NOT NULL,
		`workex`      text        NOT NULL,
		`paid`        varchar(40) NOT NULL,
		`mobileskype` varchar(60) NOT NULL,
		`extrainfo`   text        NOT NULL,
		`ccode`       varchar(10) NOT NULL,
		PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `notifications` (
    	`id` int( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    	`fullname` varchar(200) NOT NULL,
    	`email`    varchar(255) NOT NULL,
    	`type`     varchar(100) NOT NULL,
    	`time`     varchar( 30) NOT NULL,
    	`extras`   varchar(100) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `placement`(
	  `id`        int(10)      NOT NULL AUTO_INCREMENT,
	  `accountno` varchar(10)  NOT NULL,
	  `email`     varchar(254) NOT NULL,
	  `firstname` varchar(40)  NOT NULL,
	  `lastname`  varchar(40)  NOT NULL,
	  `mobileno`  varchar(20)  NOT NULL,
	  `college`   varchar(250) NOT NULL,
	  `city`      varchar(50)  NOT NULL,
	  `citypref`  varchar(50)  NOT NULL,
	  `extrainfo` text         NOT NULL,
	  `date`      varchar(30)  NOT NULL,
	   PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `projectgrade` (
		`id`        int(10)     NOT NULL AUTO_INCREMENT,
		`accountno` varchar(10) NOT NULL,
		`gradeu`    varchar(10) NOT NULL,
		`gradeq`    varchar(10) NOT NULL,
		`feedback`  text        NOT NULL,
		`date`      varchar(50) NOT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `refcontacts`(
		`id`            int(10)      NOT NULL AUTO_INCREMENT,
		`fullname`      varchar(200) NOT NULL,
		`contactemail`  varchar(255) NOT NULL,
		`contactmobile` varchar(30)  NOT NULL,
		`designation`   varchar(500) NOT NULL,
		`email`         varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
		) ENGINE = INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";	


$sql.= "CREATE TABLE IF NOT EXISTS `register`(
	    `id`        int(10)      NOT NULL AUTO_INCREMENT,
	    `firstname` varchar(40)  NOT NULL,
	    `lastname`  varchar(40)  NOT NULL,
	    `email`     varchar(255) NOT NULL,
	    `password`  varchar(255) NOT NULL,
	    `country`   varchar(20)  NOT NULL,
	    `state`     varchar(30)  NOT NULL,
	    `city`      varchar(20)  NOT NULL,
	    `phoneno`   varchar(20)  NOT NULL,
	    `college`   varchar(100) NOT NULL,
	    `aboutus`   varchar(100) NOT NULL,
	    `regtime`   varchar(30)  NOT NULL,
	    `hash`      varchar(100) NOT NULL,
	    `active`    tinyint(1)   NOT NULL,
	    `accountno` varchar(10)  NOT NULL,
	    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

$sql.="CREATE TABLE IF NOT EXISTS `results`(
        `id`              int(10)      NOT NULL AUTO_INCREMENT,
        `firstname`       varchar(20)  NOT NULL,
        `lastname`        varchar(20)  NOT NULL,
        `email`           varchar(60)  NOT NULL,
        `certificate`     varchar(10)  NOT NULL,
        `lv1`             text         NOT NULL,
        `lv2`             text         NOT NULL,
        `lv1grade`        varchar(15),
        `lv2grade`        varchar(15),
        `lvgrade`         text,
        `graded`          tinyint(1)   NOT NULL,
        `gradelevel`	  varchar(20)  NOT NULL,	
		`avg`             decimal(5,2) NOT NULL,
  		`percentile`      decimal(2,0) NOT NULL,
        `selfbelief`      decimal(5,2) NOT NULL,
        `selfaware`       decimal(5,2) NOT NULL,
        `professionalism` decimal(5,2) NOT NULL,
        `businesscomm`    decimal(5,2) NOT NULL,
        `profaware`       decimal(5,2) NOT NULL,
        `prioritization`  decimal(5,2) NOT NULL,
        `probsolve`       decimal(5,2) NOT NULL,
        `grammar`         decimal(5,2) NOT NULL,
        `ethics`          decimal(5,2) NOT NULL,
        `resulttime`      varchar(30)  NOT NULL,
        `industryconn`    tinyint(1)   NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `resume` (
	  `id`           int     (10)   NOT NULL AUTO_INCREMENT,
	  `resumeid`     varchar (10)   NOT NULL,
	  `firstname`    varchar (200)  NOT NULL,
	  `lastname`     varchar (200)  NOT NULL,
	  `mobileno`     varchar (15)   NOT NULL,
	  `email`        varchar (255)  NOT NULL,
	  `address`      text           NOT NULL,
	  `city`         varchar (100)  NOT NULL,
	  `country`      varchar (100)  NOT NULL,
	  `pincode`      varchar (10)   NOT NULL,
	  `schoolname`   varchar (1500) NOT NULL,
	  `schoolcity`   varchar (500)  NOT NULL,
	  `schoolcourse` varchar (1000) NOT NULL,
	  `schoolyear`   varchar (200)  NOT NULL,
	  `schoolmarks`  varchar (500)  NOT NULL,
	  `workcompany`  varchar (1000) NOT NULL,
	  `workdes`      varchar (1000) NOT NULL,
	  `workstart`    varchar (200)  NOT NULL,
	  `workend`      varchar (200)  NOT NULL,
	  `workresp`     text           NOT NULL,
	  `leadername`   varchar(1000)  NOT NULL,
	  `leaderdesc`   text           NOT NULL,
	  `skills`       text           NOT NULL,
	  `dateedited`   varchar(40)    NOT NULL,
	  `datecreate`   varchar(40)    NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";


$sql.= "CREATE TABLE IF NOT EXISTS `signin`(
		`id`       int(10)     NOT NULL AUTO_INCREMENT,
		`email`    varchar(50) NOT NULL,
		`signtime` varchar(30) NOT NULL,
		`login`    boolean     NOT NULL,
		PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `skillselector`(
		  `id`        int(10)      NOT NULL AUTO_INCREMENT,
		  `accountno` varchar(11)  NOT NULL,
		  `fullname`  varchar(400) NOT NULL,
		  `email`     varchar(255) NOT NULL,
		  `percent`   varchar(100) NOT NULL,
		  `answers`   varchar(100)  NOT NULL,
		  `date`      varchar(50)  NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `sndt`(
	  `id`        int(10)      NOT NULL AUTO_INCREMENT,
	  `email`     varchar(254) NOT NULL,
	  `firstname` varchar(40)  NOT NULL,
	  `lastname`  varchar(40)  NOT NULL,
	  `date`      varchar(30)  NOT NULL,
	  `sndtreg`   varchar(50)  NOT NULL,
	  `college`   varchar(200) NOT NULL,
	  `degree`    varchar(100) NOT NULL,
	  `course`    varchar(400) NOT NULL,
	  `year`      varchar(100) NOT NULL,
	  `job`       varchar(5)   NOT NULL,
	  `skill`     varchar(300) NOT NULL,
	  `skillexp`  text         NOT NULL,
	  `city_pref` varchar(300) NOT NULL,
	  `salary`    varchar(300) NOT NULL,
	  `lifegoals` text         NOT NULL,
	  `extrainfo` text         NOT NULL,
	  `accountno` varchar(10)  NOT NULL,
	   PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `teststart`(
        `id`        int(10)     NOT NULL AUTO_INCREMENT,
        `email`     varchar(50) NOT NULL,
        `accountno` varchar(10) NOT NULL,
        `starttime` varchar(30) NOT NULL,
      PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql.="CREATE TABLE IF NOT EXISTS `topscoretable` (
		  `topscore` decimal(5,2) NOT NULL,
		  `name`     varchar(100) NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;;";

$sql.="CREATE TABLE IF NOT EXISTS `webinar` (
	  `id`           int(10)      NOT NULL AUTO_INCREMENT,
	  `webinarid`    varchar(8)   NOT NULL,
	  `conductor`    varchar(100) NOT NULL,
	  `cemail`    	 varchar(100) NOT NULL,
	  `date`         varchar(50)  NOT NULL,
	  `time`         varchar(20)  NOT NULL,
	  `title`        varchar(200) NOT NULL,
	  `description`  text         NOT NULL,
	  `link`         text         NOT NULL,
	  `confirmed`    text         NOT NULL,
	  `confirmedacc` text         NOT NULL,
	   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

echo $sql;
//mysqli_multi_query($DBcon,$sql);
?>