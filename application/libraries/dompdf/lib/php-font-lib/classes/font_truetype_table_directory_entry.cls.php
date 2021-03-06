<?php
/**
 * @package php-font-lib
 * @link    http://php-font-lib.googlecode.com/
 * @author  Fabien M�nager <fabien.menager@gmail.com>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version $Id: font_truetype_table_directory_entry.cls.php,v 1.1 2013/11/28 08:02:33 toanlk Exp $
 */

require_once dirname(__FILE__)."/font_table_directory_entry.cls.php";

/**
 * TrueType table directory entry.
 * 
 * @package php-font-lib
 */
class Font_TrueType_Table_Directory_Entry extends Font_Table_Directory_Entry {
  function __construct(Font_TrueType $font) {
    parent::__construct($font);
    $this->checksum = $this->readUInt32();
    $this->offset = $this->readUInt32();
    $this->length = $this->readUInt32();
    $this->entryLength += 12;
  }
}

