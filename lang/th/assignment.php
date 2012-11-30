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
 * Strings for component 'assignment', language 'th', branch 'MOODLE_23_STABLE'
 *
 * @package   assignment
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowresubmit'] = 'อนุญาตให้ส่งการบ้านซ้ำอีกครั้ง';
$string['allowresubmit_help'] = '<p>By default, students cannot resubmit assignments once the teacher has graded them ค่าที่ตั้งไว้คือนักเรียนไม่สามารถส่งการบ้านใหม่ได้ หลังจากครูให้คะแนนแล้ว</p>

<p>If you turn this option on, then students will be allowed to resubmit assignments
   after they have been graded (for you to re-grade).  This may be useful if the
   teacher wants to encourage students to do better work in an iterative process. ถ้าหากครูเลือกให้ส่งการบ้านใหม่ได้ นักเรียนจะสามารถส่งการบ้านหลังจากที่ครูตรวจแล้ว เพื่อให้ตรวจให้คะแนนใหม่ได้ วิธีนี้มีประโยชน์ในกรณีที่ต้องการกระตุ้นเด็กให้พัฒนางานให้ดีขึ้นกว่าเดิม

</p>

<p>Obviously, this option is not relevant for offline assignments. ตัวเลือกนี้ไม่เกี่ยวข้องกับการให้ส่งการบ้านนอกเว็บแต่อย่างใด
</p>';
$string['assignmentdetails'] = 'รายละเอียดของการบ้าน';
$string['assignmentmail'] = '{$a->teacher}  ได้ทำการตรวจงาน \'{$a->assignment}\' ของคุณแล้ว

คุณสามารถดูผลการตรวจได้ที่:

{$a->url}';
$string['assignmentmailhtml'] = '{$a->teacher} ได้ทำการตรวจงาน  \'<i>{$a->assignment}</i>\'<br /><br />
คุณสามารถดูผลการตรวจได้: <a href="{$a->url}"> โดยคลิกที่นี่ </a>.';
$string['assignmentname'] = 'หัวข้อการบ้าน';
$string['assignmenttype'] = 'ประเภท';
$string['availabledate'] = 'ส่งได้ตั้งแต่';
$string['comment'] = 'ความคิดเห็น';
$string['commentinline'] = 'ความคิดเห็น';
$string['configitemstocount'] = 'จำนวนชิ้นงานที่ต้องการนำมาคิดคะแนนสำหรับงานที่ส่งแบบออนไลน์';
$string['configmaxbytes'] = 'ขนาดของไฟล์งานที่ส่งที่กำหนดไว้';
$string['description'] = 'รายละเอียด';
$string['duedate'] = 'กำหนดส่ง';
$string['duedateno'] = 'ไม่มีกำหนดส่ง';
$string['early'] = '{$a}  ก่อนกำหนด';
$string['editmysubmission'] = 'แก้ไขงานที่ส่ง';
$string['emailstudents'] = 'ส่งอีเมลเตือนไปยังนักเรียน';
$string['emailteachermail'] = '{$a->username} ได้แก้ไขการบ้าน \'{$a->assignment}\'';
$string['emailteachermailhtml'] = '{$a->username} ทำการแก้ไขการบ้าน <i>\'{$a->assignment}\'</i><br /><br />
เข้าไปตรวจการบ้าน <a href="{$a->url}">คลิกที่นี่</a>.';
$string['emailteachers'] = 'อีเมลแจ้งอาจารย์';
$string['emptysubmission'] = 'คุณยังไม่ได้ส่งการบ้านค่ะ';
$string['existingfiledeleted'] = 'ไฟล์ต่อไปนี้ถูกลบเรียบร้อยแล้ว : {$a}';
$string['failedupdatefeedback'] = 'ไม่สามารถส่งความเห็นที่มีต่องานไปยัง {$a}';
$string['feedback'] = 'ความเห็นที่มีต่องาน';
$string['feedbackfromteacher'] = 'ความเห็นจาก{$a}';
$string['feedbackupdated'] = 'ส่งความคิดเห็นที่มีต่องานไป  {$a} คน';
$string['graded'] = 'ตรวจแล้ว';
$string['guestnosubmit'] = 'ขออภัยค่ะ  บุคคลทั่วไปไม่สามารถจะส่งงานได้ ท่านต้อง เข้าสุ่ระบบ หรือ ลงทะเบียนก่อนค่ะ';
$string['guestnoupload'] = 'ขออภัยค่ะ บุคคลทั่วไปไม่สามารถทำการอัพโหลดงานได้';
$string['helpoffline'] = 'นักเรียนส่งการบ้านเป็นชิ้นงานนอกเว็บ โดยนักเรียนดูการบ้านที่ได้รับมอบหมายจากเว็บนี้ แต่จะไม่สามารถอัพโหลดไฟล์ใดๆ แล้วส่งให้ครูตรวจบนเว็บ ครูสามารถตรวจและให้คะแนนบนเว็บ จากนั้นแจ้งให้นักเรียนทราบถึงเกรดที่ได้';
$string['helponline'] = 'ให้นักเรียนตอบการบ้านโดยการเขียนตอบลงในหน้าจอ ซึ่งเหมือนกับโมดูลบันทึกความก้าวหน้าในเวอร์ชันเก่า';
$string['helpupload'] = 'การประเภทนี้อนุญาตให้นักเรียนแต่ละคนทำการอัพโหลดไฟล์หนึ่งหรือมากกว่าในทุกประเภท ซึ่งอาจจะเป็นไฟล์เวิร์ด รูปภาพ zip ไฟล์  หรืออะไรก็ตามที่ท่านต้องการให้นักเรียนส่ง  อีกทั้งสามารถให้นักเรียนอัพโหลดไฟล์ได้มากกว่าหนึ่งด้วยเช่นกัน';
$string['helpuploadsingle'] = 'นักเรียนอัพโหลดไฟล์หนึ่งไฟล์ซึ่งอยู่ในรูปแบบต่างๆ ไม่ว่าจะเป็นไฟล์เวิร์ด รูปภาพ เว็บไซต์ที่มีการซิปเรียบร้อยแล้ว หรือไฟล์อื่นๆ ที่ครูขอให้นักเรียนทำส่ง ซึ่งครูสามารถตรวจและให้คะแนนบนเว็บได้';
$string['late'] = '{$a} ช้ากว่ากำหนด';
$string['maximumgrade'] = 'คะแนนเต็ม';
$string['maximumsize'] = 'ขนาดสูงสุด';
$string['modulename'] = 'การบ้าน (2.2)';
$string['modulename_help'] = '<p><img valign="middle" SRC="<?php echo $CFG->wwwroot?>/mod/assignment/icon.gif">&nbsp;<b>การบ้าน</b></p>
<ul>
<p>เป็นส่วนที่ครูมอบหมายการบ้านให้นักเรียนทำ (เป็นเนื้อหาดิจิตอลในรูปแบบใดก็ได้) จากนั้น นักเรียนส่งชิ้นงานโดยการอัพโหลดไฟล์ขึ้นสู่เซิร์ฟเวอร์ ตัวอย่างการบ้าน ได้แก่ เรียงความ งานโปรเจ็คท์ รายงาน และอื่นๆ ซึ่งส่วนนี้จะประมวลผลการให้คะแนนนักเรียนได้ด้วย
</p>
</ul>';
$string['modulenameplural'] = 'การบ้าน';
$string['newsubmissions'] = 'การบ้านที่ส่งแล้ว';
$string['noassignments'] = 'ยังไม่มีการบ้าน';
$string['noattempts'] = 'ยังไม่มีใครส่งการบ้าน';
$string['notgradedyet'] = 'ยังไม่ได้ให้คะแนน';
$string['notsubmittedyet'] = 'ยังไม่ได้ส่งการบ้าน';
$string['onceassignmentsent'] = 'เมื่อทำการส่งการบ้านแล้ว ท่านจะไม่สามารถลบหรือแนบไฟล์ได้อีก';
$string['overwritewarning'] = 'คำเตือน: ถ้าส่งไฟล์อีกครั้ง ระบบจะทำการบันทึกไฟล์นี้ ทับไฟล์เดิมที่มีอยู่';
$string['pagesize'] = 'จำนวนการบ้านต่อหน้า';
$string['pluginname'] = 'การบ้าน (2.2)';
$string['preventlate'] = 'ไม่รับการบ้านที่ส่งช้ากว่ากำหนด';
$string['quickgrade'] = 'ใช้การให้คะแนนแบบเร็ว';
$string['saveallfeedback'] = 'บันทึกความเห็นทั้งหมด';
$string['sendformarking'] = 'ส่งการบ้าน';
$string['submission'] = 'การบ้านที่ส่ง';
$string['submissionfeedback'] = 'ความเห็นที่มีต่อของงานที่ส่ง';
$string['submissions'] = 'การบ้านที่ส่ง';
$string['submissionsaved'] = 'บันทึกการเปลี่ยนแปลงของคุณแล้ว';
$string['submissionsnotgraded'] = 'ยังไม่ได้ให้คะแนนงาน {$a} ชิ้น';
$string['submitassignment'] = 'ส่งการบ้าน';
$string['submitformarking'] = 'ส่งการบ้าน';
$string['submitted'] = 'ทำการส่งเรียบร้อยแล้ว';
$string['subplugintype_assignment'] = 'ประเภท';
$string['typeoffline'] = 'ส่งงานนอกเว็บ';
$string['typeonline'] = 'คำตอบออนไลน์';
$string['typeupload'] = 'อัพโหลดไฟล์ชั้นสูง';
$string['typeuploadsingle'] = 'ส่งโดยให้อัพโหลดไฟล์';
$string['uploadbadname'] = 'ไฟล์นี้ มีชื่อที่ใช้ตัวอักษร ไม่ถูกต้อง ไม่สามารถทำการ อัพโหลดได้ กรุณาเปลี่ยนชื่อไฟล์';
$string['uploadedfiles'] = 'ไฟล์ที่อัพโหลดแล้ว';
$string['uploaderror'] = 'เกิดข้อขัดข้องในระหว่างการบันทึกไฟล์ลงบนเซิร์ฟเวอร์';
$string['uploadfailnoupdate'] = 'อัพโหลดไฟล์เรียบร้อย แต่ไม่สามารถอัพเดท งานที่ส่งลงในแฟ้มงานของคุณ';
$string['uploadfiletoobig'] = 'ขออภัย ไฟล์มีขนาดใหญ่เกินไป( ไฟล์ควรมีขนาดน้อยกว่า {$a} bytes)';
$string['uploadnofilefound'] = 'หาไฟล์ไม่พบ กรุณาตรวจสอบว่าทำการเลือกไฟล์ ก่อนอัพโหลดหรือไม่';
$string['uploadnotregistered'] = '\'{$a}\'  อัพโหลดเรียบร้อย  แต่ว่างานที่ส่งนี้ยังไม่ได้รับการลงทะเบียน';
$string['uploadsuccess'] = 'อัพโหลดไฟล์ \'{$a}\'   สำเร็จ';
$string['viewfeedback'] = 'ดูคะแนนของงานที่ส่งและ feedback จากผู้สอน';
$string['viewsubmissions'] = 'ดู {$a} การบ้านที่ส่งทั้งหมด';
$string['yoursubmission'] = 'การบ้านที่คุณส่ง';
