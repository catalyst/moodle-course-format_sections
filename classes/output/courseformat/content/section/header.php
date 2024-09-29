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
 * Contains the default section header format output class.
 *
 * @package   format_sections
 * @copyright 2020 Ferran Recio <ferran@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace format_sections\output\courseformat\content\section;

use core_courseformat\output\local\content\section\header as header_base;
use stdClass;

/**
 * Base class to render a section header.
 *
 * @package   format_sections
 * @copyright 2020 Ferran Recio <ferran@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class header extends header_base {

    /**
     * Template name for this exporter
     *
     * @param \renderer_base $renderer
     * @return string
     */
    public function get_template_name(\renderer_base $renderer): string {
        return 'format_sections/local/content/section/header';
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param \renderer_base $output typically, the renderer that's calling this function
     * @return array data context for a mustache template
     */
    public function export_for_template(\renderer_base $output): stdClass {

        $data = parent::export_for_template($output);

        $format = $this->format;
        $section = $this->section;
        $course = $format->get_course();
        $singlesectionid = $format->get_sectionid();
        $section0 = $format->get_section(0);
        $options = $format->get_format_options();

        if (!is_null($singlesectionid) && $singlesectionid !== (int)$section0->id) {
            if (!$options['section0display']) {
                // Two sections are displaye incl. section 0.
                if (!$data->editing) {
                    $data->title = $output->section_title($section, $course);
                } else {
                    $data->title = $output->section_title_without_link($section, $course);
                }
                $data->displayonesection = false;
            }
        }

        return $data;
    }
}
