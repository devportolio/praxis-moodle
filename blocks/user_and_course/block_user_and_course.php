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
 * Block definition class for the block_user_and_course plugin.
 *
 * @package   block_user_and_course
 * @copyright Year, You Name <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_user_and_course extends block_base {
    /**
     * Holds the list of html elements in array element
     */
    private $contentElements = [];

    /**
     * Initialises the block.
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('user_and_course', 'block_user_and_course');
    }

    /**
     * Gets the block contents.
     *
     * @return string The block HTML.
     */
    public function get_content() {
        if($this->content !== NULL) {
            return $this->content;
        }

        $this->initializeContent();
        $this->setUserContent();
        $this->setCoursesContent();
        $this->setConentText();

        return $this->content;
    }

    /**
     * Initialize content
     */
    private function initializeContent() {
        $this->content = new stdClass;
    }
     
    /**
     * Set content text
     */
    private function setConentText() {
        $this->content->text = implode('', $this->contentElements);
    }

    /**
     * Set user content
     */    
    private function setUserContent() {
        global $USER;

        $this->contentElements[] = "<h5>Hi <b>$USER->firstname $USER->lastname</b>, your courses are:</h5>";
    }

    /**
     * Set user enrolled courses
     */      
    private function setCoursesContent() {
        if ($courses = enrol_get_my_courses()) {
            $this->contentElements[] = "<ul>";

            foreach ($courses as $course) {
                $this->contentElements[] = "<li>$course->fullname</li>";
            }

            $this->contentElements[] = "</ul>";
        } else {
            $this->contentElements[] = "<p>No enrolled courses</p>";
        }
    }

    /**
     * Defines in which pages this block can be added.
     *
     * @return array of the pages where the block can be added.
     */
    public function applicable_formats() {
        return [
            'admin' => false,
            'site-index' => true,
            'course-view' => true,
            'mod' => false,
            'my' => true,
        ];
    }
}