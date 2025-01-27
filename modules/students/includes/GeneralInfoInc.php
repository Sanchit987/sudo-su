<?php

#**************************************************************************
#  openSIS is a free student information system for public and non-public 
#  colleges from Open Solutions for Education, Inc. web: www.os4ed.com
#
#  openSIS is  web-based, open source, and comes packed with features that 
#  include student demographic info, scheduling, grade book, attendance, 
#  report cards, eligibility, transcripts, parent portal, 
#  student portal and more.   
#
#  Visit the openSIS web site at http://www.opensis.com to learn more.
#  If you have question regarding this system or the license, please send 
#  an email to info@os4ed.com.
#
#  This program is released under the terms of the GNU General Public License as  
#  published by the Free Software Foundation, version 2 of the License. 
#  See license.txt.
#
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#
#  You should have received a copy of the GNU General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
#***************************************************************************************
include('../../../RedirectIncludes.php');

include_once('modules/students/includes/FunctionsInc.php');

?>

<?php

$qr = DBQuery("SELECT ethnicity_name FROM ethnicity where ethnicity_id>15");
$res = DBGet($qr);
$ethnic_option = array('White, Non-Hispanic' => 'White, Non-Hispanic', 'Black, Non-Hispanic' => 'Black, Non-Hispanic', 'Hispanic' => 'Hispanic', 'American Indian or Native Alaskan' => 'American Indian or Native Alaskan', 'Pacific Islander' => 'Pacific Islander', 'Asian' => 'Asian', 'Indian' => 'Indian', 'Middle Eastern' => 'Middle Eastern', 'African' => 'African', 'Mixed Race' => 'Mixed Race', 'White British' => 'White British', 'Asian' => 'Asian', 'Black' => 'Black', 'Chinese' => 'Chinese', 'Other' => 'Other');
foreach ($res as $v) {
    $ethnic_option[$v['ETHNICITY_NAME']] = $v['ETHNICITY_NAME'];
}

$language=DBGet(DBQuery('SELECT * FROM language'));
$language_option = array($language[1]['LANGUAGE_ID'] => $language[1]['LANGUAGE_NAME'],$language[2]['LANGUAGE_ID'] => $language[2]['LANGUAGE_NAME'], $language[3]['LANGUAGE_ID'] => $language[3]['LANGUAGE_NAME'], $language[4]['LANGUAGE_ID'] => $language[4]['LANGUAGE_NAME'],$language[5]['LANGUAGE_ID'] => $language[5]['LANGUAGE_NAME'],$language[6]['LANGUAGE_ID'] => $language[6]['LANGUAGE_NAME'], $language[7]['LANGUAGE_ID'] => $language[7]['LANGUAGE_NAME'],$language[8]['LANGUAGE_ID'] => $language[8]['LANGUAGE_NAME'], $language[9]['LANGUAGE_ID'] => $language[9]['LANGUAGE_NAME'], $language[10]['LANGUAGE_ID'] => $language[10]['LANGUAGE_NAME'],$language[11]['LANGUAGE_ID'] => $language[11]['LANGUAGE_NAME'], $language[12]['LANGUAGE_ID'] => $language[12]['LANGUAGE_NAME'], $language[13]['LANGUAGE_ID'] => $language[13]['LANGUAGE_NAME'], $language[14]['LANGUAGE_ID'] => $language[14]['LANGUAGE_NAME'], $language[15]['LANGUAGE_ID'] => $language[15]['LANGUAGE_NAME'], $language[16]['LANGUAGE_ID'] => $language[16]['LANGUAGE_NAME'], $language[17]['LANGUAGE_ID'] => $language[17]['LANGUAGE_NAME'],$language[18]['LANGUAGE_ID'] => $language[18]['LANGUAGE_NAME'], $language[19]['LANGUAGE_ID'] => $language[19]['LANGUAGE_NAME'], $language[20]['LANGUAGE_ID'] => $language[20]['LANGUAGE_NAME']);
echo '<div class="row">';
echo '<div class="col-md-10">';

echo '<div class="form-horizontal">';

echo '<h5 class="text-primary">Demographic Information</h5>';

//echo '<div class="">';
//echo '<label class="co-md-3">Name <span class="text-danger">*</span>:</label>';
if ($_REQUEST['college_roll_no'] == 'new') {
    unset($_SESSION['students_order']);
    echo '<div class="well m-b-20 clearfix"><h6 class="m-t-0 text-success">Student Name</h6><div class="row"><div class="col-lg-6"><div class="form-group">' . TextInput($student['FIRST_NAME'], 'students[FIRST_NAME]', 'First Name *', 'size=12 class=form-control maxlength=50') . '</div></div><div class="col-lg-6"><div class="form-group">' . TextInput($student['MIDDLE_NAME'], 'students[MIDDLE_NAME]', 'Middle Name', 'class=form-control maxlength=50') . '</div></div></div><div class="row"><div class="col-lg-6"><div class="form-group m-b-0">' . TextInput($student['LAST_NAME'], 'students[LAST_NAME]', 'Last Name *', 'size=12 class=form-control maxlength=50') . '</div></div><div class="col-lg-6"><div class="form-group m-b-0">' . SelectInput($student['NAME_SUFFIX'], 'students[NAME_SUFFIX]', 'Suffix', array('Jr.' => 'Jr.', 'Sr.' => 'Sr.', 'II' => 'II', 'III' => 'III', 'IV' => 'IV', 'V' => 'V'), '', '') . '</div></div></div></div>';
} else
    echo '<DIV id=student_name><div class=form-group onclick=\'addHTML("<div class=\"well m-b-20 clearfix\"><h6 class=\"m-t-0 text-success\">Student Name</h6><div class=\"row\"><div class=\"col-lg-6\"><div class=\"form-group\">' . str_replace('"', '\"', TextInput($student['FIRST_NAME'], 'students[FIRST_NAME]', 'First Name *', 'maxlength=50 style="font-size:14px;"', false)) . '</div></div><div class=col-lg-6><div class=form-group>' . str_replace('"', '\"', TextInput($student['LAST_NAME'], 'students[LAST_NAME]', 'Last Name *', 'maxlength=50 ', false)) . '</div></div></div><div class=row><div class=col-lg-6><div class=\"form-group m-b-0\">' . str_replace('"', '\"', TextInput($student['MIDDLE_NAME'], 'students[MIDDLE_NAME]', 'Middle Name', 'size=3 maxlength=50', false)) . '</div></div><div class=col-lg-6><div class=\"form-group m-b-0\">' . str_replace('"', '\"', SelectInput($student['NAME_SUFFIX'], 'students[NAME_SUFFIX]', 'Suffix', array('Jr.' => 'Jr.', 'Sr.' => 'Sr.', 'II' => 'II', 'III' => 'III', 'IV' => 'IV', 'V' => 'V'), '', '', false)) . '</div></div></div></div>","student_name",true);\'><label class="control-label col-lg-2 text-right">Student Name</label><div class="col-lg-10"><h3 class="m-0 text-success">' . $student['FIRST_NAME'] . ' ' . $student['MIDDLE_NAME'] . ' ' . $student['LAST_NAME'] . ' ' . $student['NAME_SUFFIX'] . '</h3></div></div></DIV>';
//echo '</div>'; //.form-group

echo '<div class="row">';
echo '<div class="col-lg-6">';
echo '<div class="form-group"><label class="control-label col-lg-4 text-right">Estimated Grad. Date</label><div class="col-lg-8">' . DateInputAY($student['ESTIMATED_GRAD_DATE'], 'students[ESTIMATED_GRAD_DATE]', '1', false, 'MM/DD/YYYY') . '</div></div>';
echo '</div><div class="col-lg-6">';
echo '<div class="form-group"><label class="control-label col-lg-4 text-right">Gender</label><div class="col-lg-8">' . SelectInput($student['GENDER'], 'students[GENDER]', '', array('Male' => 'Male', 'Female' => 'Female'), 'N/A', '') . '</div></div>';
echo '</div>'; //.col-lg-6
echo '</div>'; //.row

echo '<div class="row">';
echo '<div class="col-lg-6">';
echo '<div class="form-group"><label class="control-label col-lg-4 text-right">Ethnicity</label><div class="col-lg-8">' . SelectInput($student['ETHNICITY'], 'students[ETHNICITY]', '', $ethnic_option, 'N/A', '') . '</div></div>';
echo '</div><div class="col-lg-6">';
echo '<div class="form-group">' . TextInput($student['COMMON_NAME'], 'students[COMMON_NAME]', 'Common Name', 'size=10 class=form-control maxlength=10') . '</div>';
echo '</div>'; //.col-lg-6
echo '</div>'; //.row

echo '<div class="row">';
echo '<div class="col-lg-6">';
//echo '<div class="form-group"><label class="control-label col-lg-4">Date of Birth<span class="text-danger">*</span></label><div class="col-lg-8">' . DateInputAY(isset($student['BIRTHDATE']) && $student['BIRTHDATE']!="" ? date("d-M-Y", strtotime($student['BIRTHDATE'])) : "", 'students[BIRTHDATE]', '2', false, '') . '</div></div>';
echo '<div class="form-group"><label class="control-label col-lg-4 text-right">Date of Birth<span class="text-danger">*</span></label><div class="col-lg-8">' . DateInputAY(isset($student['BIRTHDATE']) && $student['BIRTHDATE'] != "" ? $student['BIRTHDATE'] : "", 'students[BIRTHDATE]', '2', false, '') . '</div></div>';
echo '</div><div class="col-lg-6">';
echo '<div class="form-group"><label class="control-label col-lg-4 text-right">Language</label><div class="col-lg-8">' . SelectInput($student['LANGUAGE_ID'], 'students[LANGUAGE_ID]', '', $language_option, 'N/A', '') . '</div></div>';
echo '<input type=hidden id=current_date value=' . date('Y-m-d') . '>';
echo '</div>'; //.col-lg-6
echo '</div>'; //.row

echo '<div class="row">';
echo '<div class="col-lg-6">';
if ($_REQUEST['college_roll_no'] == 'new')
    $id_sent = 0;
else
    $id_sent = UserStudentID();
echo '<div class="form-group"><label class="control-label col-md-4 text-right">Email</label><div class="col-md-8">' . TextInput($student['EMAIL'], 'students[EMAIL]', '', 'size=100 class=cell_medium maxlength=100 onkeyup=check_email(this,' . $id_sent . ',3); onblur=check_email(this,' . $id_sent . ',3)') . '<div class="help-block" id=email_error></div></div></div>';
echo '</div><div class="col-lg-6">';
echo '<div class="form-group">' . TextInput($student['PHONE'], 'students[PHONE]', 'Phone', 'size=100 class=cell_medium maxlength=100') . '</div>';
echo '</div>'; //.col-lg-6
echo '</div>'; //.row
#############################################CUSTOM FIELDS###############################
$fields_RET = DBGet(DBQuery('SELECT ID,TITLE,TYPE,SELECT_OPTIONS,DEFAULT_SELECTION,REQUIRED,HIDE,SORT_ORDER FROM custom_fields WHERE SYSTEM_FIELD=\'N\' AND CATEGORY_ID=\'' . $_REQUEST[category_id] . '\' ORDER BY SORT_ORDER,TITLE'));

if (UserStudentID()) {
    $custom_RET = DBGet(DBQuery('SELECT * FROM students WHERE COLLEGE_ROLL_NO=\'' . UserStudentID() . '\''));
    $value = $custom_RET[1];
}


if (count($fields_RET))
    echo $separator;
$i = 1;
echo '<div class="row">';
$row = 1;
foreach ($fields_RET as $field) {
    if ($row == 3) {
        echo '</div><div class="row">';
        $row = 1;
    }
    if ($fields_RET[$q]['HIDE'] == 'Y')
        continue;
    if ($field['REQUIRED'] == 'Y') {
        $req = ' <span class=text-danger>*</span> ';
    } else {
        $req = '';
    }
    switch ($field['TYPE']) {
        case 'text':
            echo '<div class="col-md-6">';
            echo '<div class="form-group">';
            echo _makeTextInput('CUSTOM_' . $field['ID'], '', 'class=form-control', 'students', $field['TITLE']);
            echo '</div>';
            echo '</div>';
            $i++;
            break;

        case 'autos':
            echo '<div class="col-md-6">';
            echo '<div class="form-group">';
            echo '<label class="control-label col-lg-4 text-right">' . $field['TITLE'] . $req . '</label><div class="col-lg-8">';
            echo _makeAutoSelectInput('CUSTOM_' . $field['ID'], '', 'students');
            echo '</div></div>';
            echo '</div>';
            $i++;
            break;

        case 'edits':
            echo '<div class="col-md-6">';
            echo '<div class="form-group">';
            echo '<label class="control-label col-lg-4 text-right">' . $field['TITLE'] . $req . '</label><div class="col-lg-8">';
            echo _makeAutoSelectInput('CUSTOM_' . $field['ID'], '');
            echo '</div></div>';
            echo '</div>';
            $i++;
            break;

        case 'numeric':
            echo '<div class="col-md-6">';
            echo '<div class="form-group">';
            echo '<label class="control-label col-lg-4 text-right">' . $field['TITLE'] . $req . '</label><div class="col-lg-8">';
            echo _makeTextInput('CUSTOM_' . $field['ID'], '', 'size=5 maxlength=10 class=cell_medium');
            echo '</div></div>';
            echo '</div>';
            $i++;
            break;

        case 'date':
            echo '<div class="col-md-6">';
            echo '<div class="form-group">';
            echo '<label class="control-label col-lg-4 text-right">' . $field['TITLE'] . $req . '</label><div class="col-lg-8">';
            echo DateInputAY($value['CUSTOM_' . $field['ID']], 'students[CUSTOM_' . $field['ID'] . ']', $field['ID'] + 2);
            echo '<input type=hidden name=custom_date_id[] value="' . $field['ID'] . '" />';
            echo '</div></div>';
            echo '</div>';
            $i++;
            break;


        case 'codeds':
        case 'select':
            echo '<div class="col-md-6">';
            echo '<div class="form-group">';
            echo '<label class="control-label col-lg-4 text-right">' . $field['TITLE'] . $req . '</label><div class="col-lg-8">';
            echo _makeSelectInput('CUSTOM_' . $field['ID'], '', 'students');
            echo '</div></div>';
            echo '</div>';
            $i++;
            break;

        case 'multiple':
            echo '<div class="col-md-6">';
            echo '<div class="form-group">';
            echo '<label class="control-label col-lg-4 text-right">' . $field['TITLE'] . $req . '</label><div class="col-lg-8">';
            echo _makeMultipleInput('CUSTOM_' . $field['ID'], '');
            echo '</div></div>';
            echo '</div>';
            $i++;
            break;

        case 'radio':
            echo '<div class="col-md-6">';
            echo '<div class="form-group">';
            echo '<label class="control-label col-lg-4 text-right">' . $field['TITLE'] . $req . '</label><div class="col-lg-8">';
            echo _makeCheckboxInput('CUSTOM_' . $field['ID'], '');
            echo '</div></div>';
            echo '</div>';
            $i++;
            break;
    }

    $row++;
}
echo '</div>';

$i = 1;
echo '<div class="row">';
$row = 1;
foreach ($fields_RET as $field) {
    if ($row == 3) {
        echo '</div><div class="row">';
        $row = 1;
    }
    if ($field['TYPE'] == 'textarea') {
        if ($field['REQUIRED'] == 'Y') {
            $req = ' <span class="text-danger">*</span>';
        } else {
            $req = '';
        }
        echo '<div class="col-md-6">';
        echo '<div class="form-group">';
        echo '<label class="control-label col-lg-4 text-right">' . $field['TITLE'] . $req . '</label>';
        echo '<div class="col-lg-8">';
        echo _makeTextareaInput('CUSTOM_' . $field['ID'], '');
        echo '</div>'; //.col-lg-8
        echo '</div>'; //.form-group
        echo '</div>'; //.col-md-6
    }
    $row++;
}
echo '</div>'; //.row
#############################################CUSTOM FIELDS###############################


echo '<h5 class="pt-20 text-primary">College Information</h5>';


echo '<div class="row">';
echo '<div class="col-md-6">';
echo '<div class="form-group">';
if ($_REQUEST['college_roll_no'] == 'new') {
    echo NoInput('Will automatically be assigned', 'College Roll No');

    echo '<span id="ajax_output_stid"></span>';
} else
    echo NoInput(UserStudentID(), 'College Roll No');
echo '</div></div><div class="col-md-6"><div class="form-group">';
echo TextInput($student['ALT_ID'], 'students[ALT_ID]', 'Alternate ID', 'size=10 maxlength=45');
echo '</div></div>'; //.col-md-6
echo '</div>'; //.row



if ($_REQUEST['college_roll_no'] != 'new' && $student['COLLEGE_ID'])
    $college_id = $student['COLLEGE_ID'];
else
    $college_id = UserCollege();
$sql = 'SELECT ID,TITLE FROM college_gradelevels WHERE COLLEGE_ID=\'' . $college_id . '\' ORDER BY SORT_ORDER';
$QI = DBQuery($sql);
$grades_RET = DBGet($QI);
unset($options);
if (count($grades_RET)) {
    foreach ($grades_RET as $value)
        $options[$value['ID']] = $value['TITLE'];
}
if ($_REQUEST['college_roll_no'] != 'new' && $student['COLLEGE_ID'] != UserCollege()) {
    $allow_edit = $_openSIS['allow_edit'];
    $AllowEdit = $_openSIS['AllowEdit'][$_REQUEST['modname']];
    $_openSIS['AllowEdit'][$_REQUEST['modname']] = $_openSIS['allow_edit'] = false;
}

if ($_REQUEST['college_roll_no'] == 'new')
    $college_roll_no = 'new';
else
    $college_roll_no = UserStudentID();

if ($college_roll_no == 'new' && !VerifyDate($_REQUEST['day_values']['student_enrollment']['new']['START_DATE'] . '-' . $_REQUEST['month_values']['student_enrollment']['new']['START_DATE'] . '-' . $_REQUEST['year_values']['student_enrollment']['new']['START_DATE']))
    unset($student['GRADE_ID']);

echo '<div class="row">';
echo '<div class="col-md-6">';
echo '<div class="form-group"><label class="control-label col-lg-4 text-right">Grade<span class="text-danger">*</span></label><div class="col-lg-8">';
echo SelectInput($student['GRADE_ID'], 'values[student_enrollment][' . $college_roll_no . '][GRADE_ID]', '', $options, '', '') . '</div></div>';
echo '</div>'; //.col-md-6


if ($_REQUEST['college_roll_no'] != 'new' && $student['COLLEGE_ID'])
    $college_id = $student['COLLEGE_ID'];
else
    $college_id = UserCollege();
$sql = 'SELECT * FROM college_gradelevel_sections WHERE COLLEGE_ID=\'' . $college_id . '\' ORDER BY SORT_ORDER';
$QI = DBQuery($sql);
$sec_RET = DBGet($QI);
unset($options);
if (count($sec_RET)) {
    foreach ($sec_RET as $value)
        $options[$value['ID']] = $value['NAME'];
}
if ($_REQUEST['college_roll_no'] != 'new' && $student['COLLEGE_ID'] != UserCollege()) {
    $allow_edit = $_openSIS['allow_edit'];
    $AllowEdit = $_openSIS['AllowEdit'][$_REQUEST['modname']];
    $_openSIS['AllowEdit'][$_REQUEST['modname']] = $_openSIS['allow_edit'] = false;
}

if ($_REQUEST['college_roll_no'] == 'new')
    $enrollment_id = 'new';
else
    $enrollment_id = $student['ENROLLMENT_ID'];

if ($college_roll_no == 'new' && !VerifyDate($_REQUEST['day_values']['student_enrollment']['new']['START_DATE'] . '-' . $_REQUEST['month_values']['student_enrollment']['new']['START_DATE'] . '-' . $_REQUEST['year_values']['student_enrollment']['new']['START_DATE']))
    unset($student['SECTION_ID']);

echo '<div class="col-md-6">';
echo '<div class="form-group"><label class="control-label col-lg-4 text-right">Section</label><div class="col-lg-8">';
echo SelectInput($student['SECTION_ID'], 'values[student_enrollment][' . $enrollment_id . '][SECTION_ID]', '', $options, '', '') . '</div></div>';
echo '</div>'; //.col-md-6
echo '</div>'; //.row






echo '<h5 class="pt-20 text-primary">Access Information</h5>';
echo '<div class="row">';
echo '<div class="col-lg-6">';
echo '<div class="form-group">';
echo '<label class="control-label col-md-4 text-right">Username</label>';
echo '<div class="col-md-8">';
echo TextInput($student['USERNAME'], 'students[USERNAME]', '', 'onkeyup="usercheck_init_student(this)" onBlur="usercheck_init_student_Mod(this)"');
echo '<div class="help-block" id="ajax_output_st"></div>';
echo '</div>';
echo '</div>'; //.form-group
echo '</div><div class="col-lg-6">';
echo '<div class="form-group">';
echo '<label class="control-label text-right col-lg-4">Password</label>';
echo '<div class="col-lg-8">';
echo TextInput(str_repeat('*', strlen($student['PASSWORD'])), 'students[PASSWORD]', '', 'onkeyup=passwordStrength(this.value)', 'AUTOCOMPLETE = off');
echo '<p id="passwordStrength" class="help-block"></p>';
echo '</div>';
echo '</div>';
echo '</div>'; //.col-md-6
echo '</div>'; //.row


echo '<div class="row">';
if ($_REQUEST['college_roll_no'] != 'new') {
    echo '<div class="col-lg-6">';
    echo '<div class="form-group">' . NoInput(ProperDate(substr($student['LAST_LOGIN'], 0, 10)) . substr($student['LAST_LOGIN'], 10), 'Last Login');
    echo '</div></div>'; //.col-lg-6

    if (User('PROFILE') == 'admin') {
        echo '<div class="col-lg-6">';
        echo '<div class="form-group"><label class="control-label col-lg-4 text-right">Disable Student</label><div class="col-lg-8">';
        echo CheckboxInput($student['IS_DISABLE'], 'students[IS_DISABLE]', '', 'CHECKED', $new, '<i class="icon-checkbox-checked"></i>', '<i class="icon-checkbox-unchecked"></i>');
        echo '</div></div></div>';
    }
}
echo '</div>'; //.row
echo '</div>'; //.form-horizontal


echo '</div>'; //.col-md-10 (Main columns)
echo '<div class="col-md-2">';


if (UserStudentID()) {
    $stu_img_info = DBGet(DBQuery('SELECT * FROM user_file_upload WHERE USER_ID=' . UserStudentID() . ' AND PROFILE_ID=3 AND COLLEGE_ID=' . UserCollege() . ' AND SYEAR=' . UserSyear() . ' AND FILE_INFO=\'stuimg\''));
}
if ($_REQUEST['college_roll_no'] != 'new' && count($stu_img_info) > 0) {

    echo '<div width=150 align="center"><IMG src="data:image/jpeg;base64,' . base64_encode($stu_img_info[1]['CONTENT']) . '" width=150 class=pic>';
    if (User('PROFILE') == 'admin' && User('PROFILE') != 'student' && User('PROFILE') != 'parent')
        echo '<br><a href=Modules.php?modname=students/Upload.php?modfunc=edit class="btn btn-white btn-xs m-t-5"><b>Change Photo</b></a></div>';
    else
        echo '';
}
else {
    if ($_REQUEST['college_roll_no'] != 'new') {

        echo '<div align="center">Upload Student\'s Photo:<br/><IMG SRC="assets/noimage.jpg?id=' . rand(6, 100000) . '" width=144 class=pic>';
        if (User('PROFILE') == 'admin' && User('PROFILE') != 'student' && User('PROFILE') != 'parent') {
            echo '<label class="fileUpload btn btn-primary btn-xs btn-block m-t-10"><span>Select File</span><input id="uploadBtn" type="file" name="file" class="upload" onchange="selectFile(this)" /></label>';
            echo '<div id="uploadFile"></div>';
        }
    } else {
        echo '<div align="center">Upload Student\'s Photo:<br/><IMG SRC="assets/noimage.jpg?id=' . rand(6, 100000) . '" width=144 class=pic>';
        if (User('PROFILE') == 'admin' && User('PROFILE') != 'student' && User('PROFILE') != 'parent')
            echo '<label class="fileUpload btn_ btn btn-primary btn-block btn-xs"><span>Select File</span><input id="uploadBtn" type="file" name="file" class="upload" onchange="selectFile(this)" /></label>';
        echo '<div id="uploadFile"></div>';
    }
}

echo '</div>'; //.col-md-2
echo '</div>'; //.row
//////////////Modal For Filter Save////////////////////
echo '<div id="modal_crop_image" class="modal fade">';
echo '<div class="modal-dialog">';
echo '<div class="modal-content">';
echo '<div class="modal-header">';
echo '<button type="button" class="close" data-dismiss="modal">×</button>';
echo '<h5 class="modal-title">Upload Photo</h5>';
echo '</div>';

echo '<div class="modal-body">';
echo '<div class="image-cropper-container content-group" id=div_img style="height: 400px;">
          <img src="" alt="" class="cropper" id="demo-cropper-image">
          
      </div>';
echo '<input type=hidden name=imgblob id=imgblob value=>';
echo '<input type="submit" class="btn btn-primary legitRipple" name="upbtn" value="Upload">';
echo '</div>'; //.modal-body

echo '</div>'; //.modal-content
echo '</div>'; //.modal-dialog
echo '</div>'; //.modal
?>
