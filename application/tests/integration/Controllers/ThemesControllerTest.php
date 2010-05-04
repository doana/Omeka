<?php
/**
 * @version $Id$
 * @copyright Center for History and New Media, 2007-2010
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka
 **/

/**
 * Test themes controller.
 *
 * @package Omeka
 * @copyright Center for History and New Media, 2007-2010
 **/
class Omeka_Controller_ThemesControllerTest extends Omeka_Test_AppTestCase
{   
    public function setUp()
    {
        parent::setUp();        
        set_option('enable_header_check_for_file_mime_types', '1');
    }
    
    public function assertPreConditions()
    {
        $this->assertEquals('1', get_option('enable_header_check_for_file_mime_types'));        
    }
    
    public function testConfigureSeasonsThemeWithNoLogoFileAndNoPreviousLogoFile()
    {
        $themeName = 'seasons';
        $this->assertEquals('', (string)get_theme_option('logo', $themeName));
        
        // specify the files array for the post
        $_FILES = array(
            'logo' => 
                array(
                  'name' => '',
                  'type' => '',
                  'tmp_name' => '',
                  'error' => 4,
                  'size' => 0
                )
        );
        
        // specify the theme options for the post
        $themeOptions = array(
          'style_sheet' => 'winter',
          'custom_header_navigation' => '',
          'display_featured_item' => '1',
          'display_featured_collection' => '1',
          'display_featured_exhibit' => '1',
          'homepage_recent_items' => '',
          'homepage_text' => '',
          'display_dublin_core_fields' => '',
          'footer_text' => '',
          'display_footer_copyright' => '0'
        );
        
        // specify other post data
        $otherPostData = array(
          'hidden_file_logo' => '',
          'MAX_FILE_SIZE' => '33554432',
          'submit' => 'Save Changes'
        );
        
        // set the the post data
        $post = array_merge($themeOptions, $otherPostData);
        $this->getRequest()->setParam('name', $themeName);
        $this->getRequest()->setPost($post);
        $this->getRequest()->setMethod('POST');
        
        // dispatch the controller action
        $this->dispatch('themes/config', true);
        
        foreach($themeOptions as $themeOptionName => $themeOptionValue) {
            $this->assertEquals($themeOptionValue, get_theme_option($themeOptionName, $themeName));
        }
        
        // verify that logo is empty
        $this->assertEquals('', get_theme_option('logo', $themeName));
    }
    
    public function testConfigureSeasonsThemeWithWithNewLogoFileAndNoPreviousLogoFile()
    {  
        $themeName = 'seasons';
        $this->assertEquals('', (string)get_theme_option('logo', $themeName));
        
        // specify the files array for the post
        $logoFileName = 'test.jpg';
        $logoFilePath = TEST_DIR . '/_files/' . $logoFileName;        
        $this->assertTrue(is_file($logoFilePath));
        
        $_FILES = array(
            'logo' => 
                array(
                  'name' => $logoFileName,
                  'type' => 'image/jpeg',
                  'tmp_name' => $logoFilePath,
                  'error' => 4,
                  'size' => filesize($logoFilePath)
                )
        );
                
        // specify the theme options for the post
        $themeOptions = array(
          'style_sheet' => 'winter',
          'custom_header_navigation' => '',
          'display_featured_item' => '1',
          'display_featured_collection' => '1',
          'display_featured_exhibit' => '1',
          'homepage_recent_items' => '',
          'homepage_text' => '',
          'display_dublin_core_fields' => '',
          'footer_text' => '',
          'display_footer_copyright' => '0'
        );
        
        // specify other post data
        $otherPostData = array(
          'hidden_file_logo' => '',
          'MAX_FILE_SIZE' => '33554432',
          'submit' => 'Save Changes'
        );
        
        // set the the post data
        $post = array_merge($themeOptions, $otherPostData);
        $this->getRequest()->setParam('name', $themeName);
        $this->getRequest()->setPost($post);
        $this->getRequest()->setMethod('POST');
        
        // dispatch the controller action
        $this->dispatch('themes/config', true);
        
        foreach($themeOptions as $themeOptionName => $themeOptionValue) {
            $this->assertEquals($themeOptionValue, get_theme_option($themeOptionName, $themeName));
        }
        
        $uploadedLogoFileName = $themeName . '_logo_' . $logoFileName;
        $this->assertEquals($uploadedLogoFileName, get_theme_option('logo', $themeName));        
    }
}
