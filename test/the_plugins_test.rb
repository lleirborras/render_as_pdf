# run from command line "ruby the_plugins_test.rb"
#
# These tests are testing hooks that this plugin modifies
# These tests are written to test standard ruby/rails functions
# Note that it requires access to the standard ruby/rails plugins that it modifies

# require standard gems
require 'rubygems'
require 'test/unit'

require 'active_record'
require 'action_view'
require 'active_support'


require File.dirname(__FILE__) + '/../lib/render_as_pdf'
require File.dirname(__FILE__) + '/../lib/render_as_pdf_functions'


class ThePluginsTest < Test::Unit::TestCase
	include RenderAsPdfFunctions 

  def test_render_as_pdf_class_generates_random_strings
    string1 = RenderAsPdf.generate_random_string
    string2 = RenderAsPdf.generate_random_string
    assert_equal string1.size, 10
    assert_equal string2.size, 10
    assert_match /[a-z0-9]{10}/, string1
    assert_match /[a-z0-9]{10}/, string2
    assert_not_equal string1, string2 
  end

  def test_render_as_pdf_generate_temp_filename
    FileUtils.rm_rf(RenderAsPdf.temp_path)
    assert !File.exist?(RenderAsPdf.temp_path)
    filename = "test_file"
    file_path = RenderAsPdf.generate_temp_filename filename
    assert File.exist?(RenderAsPdf.temp_path)
    assert !File.exist?(file_path)

    FileUtils.touch file_path
    assert File.exist?(file_path)
    new_file_path = RenderAsPdf.generate_temp_filename filename
    assert_equal file_path + "_", new_file_path
  end

  def test_file_footer
    

  end
end
