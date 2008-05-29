<?php
/**
 * @version $Id$
 * @copyright Center for History and New Media, 2007-2008
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka
 **/

require_once 'FileMetaLookupTable.php';

/**
 * @package Omeka
 * @author CHNM
 * @copyright Center for History and New Media, 2007-2008
 **/
class FileMetaLookup extends Omeka_Record
{
    public $mime_type;
    public $table_name;
    public $table_class;
}