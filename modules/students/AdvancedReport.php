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
include('../../RedirectModulesInc.php');
if (clean_param($_REQUEST['modfunc'], PARAM_ALPHAMOD) == 'save') {
    if (count($_SESSION['st_arr'])) {
        $st_list = '\'' . implode('\',\'', $_SESSION['st_arr']) . '\'';
        $extra['WHERE'] = ' AND s.COLLEGE_ROLL_NO IN (' . $st_list . ')';
        if ($_REQUEST['ADDRESS_ID']) {
            $extra['singular'] = 'Family';
            $extra['plural'] = 'Families';
            $extra['group'] = $extra['LO_group'] = array('ADDRESS_ID');
        }

        echo "<table width=100%  style=\" font-family:Arial; font-size:12px;\" >";
        echo "<tr><td width=105>" . DrawLogo() . "</td><td style=\"font-size:15px; font-weight:bold; padding-top:20px;\">" . GetCollege(UserCollege()) . "<div style=\"font-size:12px;\">Student Advanced Report</div></td><td align=right style=\"padding-top:20px;\">" . ProperDate(DBDate()) . "<br />Powered by openSIS</td></tr><tr><td colspan=3 style=\"border-top:1px solid #333;\">&nbsp;</td></tr></table>";
        echo "<table >";
        include('modules/miscellaneous/Export.php');
    }
}
if (clean_param($_REQUEST['modfunc'], PARAM_ALPHAMOD) == 'call') {
    $_SESSION['st_arr'] = $_REQUEST['st_arr'];
    echo "<FORM action=ForExport.php?modname=$_REQUEST[modname]&head_html=Student+Advanced+Report&modfunc=save&search_modfunc=list&_openSIS_PDF=true&include_inactive=$_REQUEST[include_inactive]&_search_all_colleges=$_REQUEST[_search_all_colleges] onsubmit=document.forms[0].relation.value=document.getElementById(\"relation\").value; method=POST target=_blank>";
    echo '<DIV id=fields_div></DIV>';
    echo '<INPUT type=hidden name=relation>';

    $extra['search'] .= '<div class="row">';
    $extra['search'] .= '<div class="col-lg-6">';
    Widgets('course');
    Widgets('activity');
    Widgets('gpa');
    Widgets('letter_grade');
    $extra['search'] .= '</div><div class="col-lg-6">';
    Widgets('request');
    Widgets('absences');
    Widgets('class_rank');
    Widgets('eligibility');
    $extra['search'] .= '</div>'; //.col-lg-6
    $extra['search'] .= '</div>'; //.row


    $extra['search'] .= '<div class="form-group"><label>Include courses active as of</label>' . DateInputAY('', 'include_active_date', 1) . '</div>';
    $extra['new'] = true;
    include('modules/miscellaneous/Export.php');
    echo '<BR><CENTER><INPUT type=submit value=\'Create Report for Selected Students\' class="btn btn-primary"></CENTER>';
    echo "</FORM>";
}
$modal_flag = 1;
if ($_REQUEST['modname'] == 'students/AdvancedReport.php' && $_REQUEST['modfunc'] == 'save')
    $modal_flag = 0;
if ($modal_flag == 1) {
    echo '<div id="modal_default" class="modal fade">';
    echo '<div class="modal-dialog modal-lg">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<button type="button" class="close" data-dismiss="modal">×</button>';
    echo '<h5 class="modal-title">Choose course</h5>';
    echo '</div>';

    echo '<div class="modal-body">';
    echo '<center><div id="conf_div"></div></center>';

    echo '<div class="row" id="resp_table">';
    echo '<div class="col-md-4">';
    $sql = "SELECT SUBJECT_ID,TITLE FROM course_subjects WHERE COLLEGE_ID='" . UserCollege() . "' AND SYEAR='" . UserSyear() . "' ORDER BY TITLE";
    $QI = DBQuery($sql);
    $subjects_RET = DBGet($QI);

    echo '<h6>' . count($subjects_RET) . ((count($subjects_RET) == 1) ? ' Subject was' : ' Subjects were') . ' found.</h6>';
    if (count($subjects_RET) > 0) {
        echo '<table class="table table-bordered"><thead><tr class="alpha-grey"><th>Subject</th></tr></thead><tbody>';
        foreach ($subjects_RET as $val) {
            echo '<tr><td><a href=javascript:void(0); onclick="chooseCpModalSearch(' . $val['SUBJECT_ID'] . ',\'courses\')">' . $val['TITLE'] . '</a></td></tr>';
        }
        echo '</tbody></table>';
    }
    echo '</div>';
    echo '<div class="col-md-4"><div id="course_modal"></div></div>';
    echo '<div class="col-md-4"><div id="cp_modal"></div></div>';
    echo '</div>'; //.row
    echo '</div>'; //.modal-body

    echo '</div>'; //.modal-content
    echo '</div>'; //.modal-dialog
    echo '</div>'; //.modal




    echo '<div id="modal_default_request" class="modal fade">';
    echo '<div class="modal-dialog">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<button type="button" class="close" data-dismiss="modal">×</button>';
    echo '<h5 class="modal-title">Choose course</h5>';
    echo '</div>';

    echo '<div class="modal-body">';
    echo '<center><div id="conf_div"></div></center>';

    echo '<div class="row" id="resp_table">';
    echo '<div class="col-md-6">';
    $sql = "SELECT SUBJECT_ID,TITLE FROM course_subjects WHERE COLLEGE_ID='" . UserCollege() . "' AND SYEAR='" . UserSyear() . "' ORDER BY TITLE";
    $QI = DBQuery($sql);
    $subjects_RET = DBGet($QI);

    echo count($subjects_RET) . ((count($subjects_RET) == 1) ? ' Subject was' : ' Subjects were') . ' found.<br>';
    if (count($subjects_RET) > 0) {
        echo '<table class="table table-bordered"><thead><tr class="alpha-grey"><th>Subject</th></tr></thead><tbody>';
        foreach ($subjects_RET as $val) {
            echo '<tr><td><a href=javascript:void(0); onclick="chooseCpModalSearchRequest(' . $val['SUBJECT_ID'] . ',\'courses\')">' . $val['TITLE'] . '</a></td></tr>';
        }
        echo '</tbody></table>';
    }
    echo '</div>';
    echo '<div class="col-md-6"><div id="course_modal_request"></div></div>';
    echo '</div>'; //.row
    echo '</div>'; //.modal-body

    echo '</div>'; //.modal-content
    echo '</div>'; //.modal-dialog
    echo '</div>'; //.modal
}

if (!$_REQUEST['modfunc']) {
    DrawBC("Students > " . ProgramTitle());

    if ($_REQUEST['search_modfunc'] == 'list' || $_REQUEST['search_modfunc'] == 'select') {
        $_REQUEST['search_modfunc'] = 'select';

        $extra['link'] = array('FULL_NAME' => false);
        $extra['SELECT'] = ",s.COLLEGE_ROLL_NO AS CHECKBOX";
        $extra['functions'] = array('CHECKBOX' => '_makeChooseCheckbox');
//        $extra['SELECT'] = ",CONCAT('<INPUT type=checkbox name=st_arr[] value=',s.COLLEGE_ROLL_NO,' checked>') AS CHECKBOX";

        $extra['columns_before'] = array('CHECKBOX' => '</A><INPUT type=checkbox value=Y name=controller onclick="checkAllDtMod(this,\'st_arr\');"><A>');
        $extra['options']['search'] = false;


        echo "<FORM action=Modules.php?modname=$_REQUEST[modname]&modfunc=call method=POST>";
        echo '<DIV id=fields_div></DIV>';
        if ($_REQUEST['include_inactive'])
            echo '<INPUT type=hidden name=include_inactive value=' . $_REQUEST['include_inactive'] . '>';
        echo '<INPUT type=hidden name=relation>';

        $extra['search'] .= '<div class="row">';
        $extra['search'] .= '<div class="col-lg-6">';
        Widgets('course');
        Widgets('activity');
        Widgets('gpa');
        Widgets('letter_grade');
        $extra['search'] .= '</div><div class="col-lg-6">';
        Widgets('request');
        Widgets('absences');
        Widgets('class_rank');
        Widgets('eligibility');
        $extra['search'] .= '<div class="form-group"><label class="control-label col-lg-4">Include courses active as of </label><div class="col-lg-8">' . DateInputAY('', 'include_active_date', 2) . '</div></div>';
        $extra['search'] .= '</div>'; //.col-lg-6
        $extra['search'] .= '</div>'; //.row

        $extra['new'] = true;

        Search('college_roll_no', $extra);

        if ($_SESSION['count_stu'] != '0') {
            unset($_SESSION['count_stu']);
            echo '<div class="text-right p-b-20 p-r-20"><INPUT type=submit value=\'Create Report for Selected Students\' class="btn btn-primary"></div>';
        }
        echo "</FORM>";
    } else {
        $extra['search'] .= '<div class="row">';
        $extra['search'] .= '<div class="col-lg-6">';
        
        Widgets('course');
        Widgets('activity');
        $extra['search'] .= '<div class="well mb-20">';
        Widgets('absences');
        $extra['search'] .= '</div>'; //.well
        $extra['search'] .= '<div class="well mb-20">';
        Widgets('gpa');
        $extra['search'] .= '</div>'; //.well
        $extra['search'] .= '<div class="form-group"><label class="control-label col-lg-4 text-right">Include courses active as of </label><div class="col-lg-8">' . DateInputAY('', 'include_active_date', 3) . '</div></div>';
        
        $extra['search'] .= '</div><div class="col-lg-6">';
        
        Widgets('request');
        Widgets('eligibility');
        $extra['search'] .= '<div class="well mb-20">';
        Widgets('class_rank');
        $extra['search'] .= '</div>'; //.well
        $extra['search'] .= '<div class="well mb-20">';
        Widgets('letter_grade');
        $extra['search'] .= '</div>'; //.well
        
        $extra['search'] .= '</div>'; //.col-lg-6
        $extra['search'] .= '</div>'; //.row



        $extra['new'] = true;

        Search('college_roll_no', $extra);
    }
}

function _makeChooseCheckbox($value, $title) {
    global $THIS_RET;
//    return '<INPUT type=checkbox name=st_arr[] value=' . $value . ' checked>';
    
    return "<input name=unused[$THIS_RET[COLLEGE_ROLL_NO]] value=" . $THIS_RET[COLLEGE_ROLL_NO] . "  type='checkbox' id=$THIS_RET[COLLEGE_ROLL_NO] onClick='setHiddenCheckboxStudents(\"st_arr[]\",this,$THIS_RET[COLLEGE_ROLL_NO]);' />";
}
?>