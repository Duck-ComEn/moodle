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
 * Strings for component 'question', language 'th', branch 'MOODLE_23_STABLE'
 *
 * @package   question
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['cannotdeletemissingqtype'] = 'ไม่สามารถลบประเภทของคำถามที่หายไปได้ เพราะยังมีการใช้งานอยู่ในระบบ';
$string['cannotdeleteqtypeinuse'] = 'ไม่สามารถลบประเภทของคำถาม \'{$a}\' นี้ได้เพราะยังมีคำถามอยู่ในคลังข้อสอบ';
$string['cannotdeleteqtypeneeded'] = 'ไม่สามารถลบประเภทของคำถาม \'{$a}\' นี้ได้ ยังมีการใช้งานคำถามประเภทอื่นที่ยังใช้งานเกี่ยวเนื่องกันอยู่';
$string['cannotread'] = 'ไม่สามารถอ่านไฟล์นำเข้า (หรือไฟล์ไม่มีเนื้อหาใด)';
$string['categorymove'] = 'ประเภท \'{$a->name}\' contains {$a->count} questions.  กรุณาเลือกประเภทอื่นที่ต้องการย้ายไป';
$string['deleteqtypeareyousure'] = 'แน่ในนะคะว่าต้องการลบคำถามประเภท  \'{$a}\' ?';
$string['deleteqtypeareyousuremessage'] = 'คุณกำลังจะลบคำถามประเภท  \'{$a}\' ออกจากระบบ แน่ใจนะคะว่าต้องการลบ ?';
$string['deletingqtype'] = 'กำลังลบประเภทคำถาม \'{$a}\'';
$string['exportfilename'] = 'แบบทดสอบ';
$string['exportnameformat'] = '%Y%m%d-%H%M';
$string['exportquestions_help'] = '<p>This function allows you to export a complete category of questions to
   a text file.

<p>Please note that in many file formats some information is lost
   when the questions are exported. This is because many formats do
   not possess all the features that exist in Moodle questions. You should
   not expect to export and import questions and for them to be
   identical. Also some question types may not export at all.
   You are advised to check exported data before using
   it in a production environment.</p>

<p>The format(s) currently supported are:</p>

<p><b>GIFT format</b></p>
<ul>
<p>GIFT is the most comprehensive import/export format available for exporting
   Moodle quiz questions to a text file.  It was designed to be an easy
   method for teachers writing questions as a text file. It supports Multiple-Choice,
   True-False, Short Answer, Matching and Numerical questions, as well as insertion
   of a _____ for the "missing word" format.  Note that Cloze questions are not
   currently supported. Various question-types can be
   mixed in a single text file, and the format also supports line comments, question names,
   feedback and percentage-weight grades.  Below are some examples:</p>
<pre>
Who\'s buried in Grant\'s tomb?{~Grant ~Jefferson =no one}

Grant is {~buried =entombed ~living} in Grant\'s tomb.

Grant is buried in Grant\'s tomb.{FALSE}

Who\'s buried in Grant\'s tomb?{=no one =nobody}

When was Ulysses S. Grant born?{#1822}
</pre>

<p align="right"><a href="help.php?file=formatgift.html&module=quiz">More info about the "GIFT" format</a></p>
</ul>

<p>More formats are yet to come, including WebCT, IMS QTI and whatever else
   Moodle users can contribute! </p>';
$string['noquestionsinfile'] = 'ไม่มีคำถามในไฟล์ที่นำเข้า';
$string['numquestions'] = 'จำนวนคำถาม';
$string['numquestionsandhidden'] = '{$a->numquestions} (+{$a->numhidden} ซ่อนอยู่)';
$string['penaltyfactor'] = 'องค์ประกอบสำหรับการหักคะแนน';
$string['qtypedeletefiles'] = 'ข้อมูลทั้งหมดที่เกี่ยวข้องกับประเภทคำถาม  \'{$a->qtype}\'  ได้ถูกลบจากฐานข้อมูลแล้ว เพื่อป้องกันไม่ให้คำถามประเภทนี้ติดตั้งตัวเองขึ้นใหม่ในระบบควรทำการลบไดเรกทอรีต่อไปนี้จากเซิร์ฟเวอร์ {$a->directory}';
$string['selectcategoryabove'] = 'เลือกประเภทข้างบน';
$string['uninstallqtype'] = 'นำคำประเภทคำถามนี้ออกจากระบบ';
