<?php  // $Id: view.php,v 1.6.2.3 2009/04/17 22:06:25 skodak Exp $

/**
 * This page prints a particular instance of matrix
 *
 * @author  Your Name <your@email.address>
 * @version $Id: view.php,v 1.6.2.3 2009/04/17 22:06:25 skodak Exp $
 * @package mod/matrix
 */

/// (Replace matrix with the name of your module and remove this line)

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$a  = optional_param('a', 0, PARAM_INT);  // matrix instance ID

if ($id) {
    if (! $cm = get_coursemodule_from_id('matrix', $id)) {
        error('Course Module ID was incorrect');
    }

    if (! $course = get_record('course', 'id', $cm->course)) {
        error('Course is misconfigured');
    }

    if (! $matrix = get_record('matrix', 'id', $cm->instance)) {
        error('Course module is incorrect');
    }

} else if ($a) {
    if (! $matrix = get_record('matrix', 'id', $a)) {
        error('Course module is incorrect');
    }
    if (! $course = get_record('course', 'id', $matrix->course)) {
        error('Course is misconfigured');
    }
    if (! $cm = get_coursemodule_from_instance('matrix', $matrix->id, $course->id)) {
        error('Course Module ID was incorrect');
    }

} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

add_to_log($course->id, "matrix", "view", "view.php?id=$cm->id", "$matrix->id");

/// Print the page header
$strmatrixs = get_string('modulenameplural', 'matrix');
$strmatrix  = get_string('modulename', 'matrix');

$navlinks = array();
$navlinks[] = array('name' => $strmatrixs, 'link' => "index.php?id=$course->id", 'type' => 'activity');
$navlinks[] = array('name' => format_string($matrix->name), 'link' => '', 'type' => 'activityinstance');

$navigation = build_navigation($navlinks);

print_header_simple(format_string($matrix->name), '', $navigation, '', '', true,
              update_module_button($cm->id, $course->id, $strmatrix), navmenu($course, $cm));

/// Print the main part of the page

echo 'YOUR CODE GOES HERE';


/// Finish the page
print_footer($course);

?>
