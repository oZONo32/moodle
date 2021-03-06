<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package moodlecore
 * @subpackage backup
 * @copyright 2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Abstract class defining common stuff to be used by the backup stuff
 *
 * This class defines various constants and methods that will be used
 * by different classes, all related with the backup process. Just provides
 * the top hierarchy of the backup controller/worker stuff.
 *
 * TODO: Finish phpdocs
 */
abstract class backup implements checksumable {

    // Backup type
    const TYPE_1ACTIVITY = 'activity';
    const TYPE_1SECTION  = 'section';
    const TYPE_1COURSE   = 'course';

    // Backup format
    const FORMAT_MOODLE  = 'moodle2';
    const FORMAT_MOODLE1 = 'moodle1';
    const FORMAT_IMSCC1  = 'imscc1';
    const FORMAT_IMSCC11 = 'imscc11';
    const FORMAT_UNKNOWN = 'unknown';

    // Interactive
    const INTERACTIVE_YES = true;
    const INTERACTIVE_NO  = false;

    // Predefined modes (purposes) of the backup
    const MODE_GENERAL   = 10;
    const MODE_IMPORT    = 20;
    const MODE_HUB       = 30;
    const MODE_SAMESITE  = 40;
    const MODE_AUTOMATED = 50;
    const MODE_CONVERTED = 60;

    // Target (new/existing/current/adding/deleting)
    const TARGET_CURRENT_DELETING = 0;
    const TARGET_CURRENT_ADDING   = 1;
    const TARGET_NEW_COURSE       = 2;
    const TARGET_EXISTING_DELETING= 3;
    const TARGET_EXISTING_ADDING  = 4;

    // Execution mode
    const EXECUTION_INMEDIATE = 1;
    const EXECUTION_DELAYED   = 2;

    // Status of the backup_controller
    const STATUS_CREATED     = 100;
    const STATUS_REQUIRE_CONV= 200;
    const STATUS_PLANNED     = 300;
    const STATUS_CONFIGURED  = 400;
    const STATUS_SETTING_UI  = 500;
    const STATUS_NEED_PRECHECK=600;
    const STATUS_AWAITING    = 700;
    const STATUS_EXECUTING   = 800;
    const STATUS_FINISHED_ERR= 900;
    const STATUS_FINISHED_OK =1000;

    // Logging levels
    const LOG_DEBUG   = 50;
    const LOG_INFO    = 40;
    const LOG_WARNING = 30;
    const LOG_ERROR   = 20;
    const LOG_NONE    = 10;

    // Some constants used to identify some helpfull processor variables
    // (using negative numbers to avoid any collision posibility
    // To be used when defining backup structures
    const VAR_COURSEID   = -1;  // To reference id of course in a processor
    const VAR_SECTIONID  = -11; // To reference id of section in a processor
    const VAR_ACTIVITYID = -21; // To reference id of activity in a processor
    const VAR_MODID      = -31; // To reference id of course_module in a processor
    const VAR_MODNAME    = -41; // To reference name of module in a processor
    const VAR_BLOCKID    = -51; // To reference id of block in a processor
    const VAR_BLOCKNAME  = -61; // To reference name of block in a processor
    const VAR_CONTEXTID  = -71; // To reference context id in a processor
    const VAR_PARENTID   = -81; // To reference the first parent->id in a backup structure

    // Used internally by the backup process
    const VAR_BACKUPID   = -1001; // To reference the backupid being processed
    const VAR_BASEPATH   = -1011; // To reference the dir where the file is generated

    // Type of operation
    const OPERATION_BACKUP  ='backup'; // We are performing one backup
    const OPERATION_RESTORE ='restore';// We are performing one restore

    // Version (to keep CFG->backup_version (and release) updated automatically)
    const VERSION = 2013050100;
    const RELEASE = '2.6';
}

/*
 * Exception class used by all the @backup stuff
 */
abstract class backup_exception extends moodle_exception {

    public function __construct($errorcode, $a=NULL, $debuginfo=null) {
        parent::__construct($errorcode, 'error', '', $a, $debuginfo);
    }
}
