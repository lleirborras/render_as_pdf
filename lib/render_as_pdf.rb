class RenderAsPdf 
  
  @@render_as_pdf_path = File.join(File.dirname(__FILE__), "php", "html2pdf.class.php")
  @@temp_path = File.join(File.dirname(__FILE__), "..", "..", "..", "tmp", "pdf")
  
  @@file_header = <<-raw
<?php
  ob_start();
?>
  raw

  cattr_reader :render_as_pdf_path  
  cattr_accessor :temp_path
  cattr_reader :file_header
  
  class<<self
  
    def generate_random_string
      chars = ("a".."z").to_a + (0..9).to_a
      return (1..10).collect{ |a| chars[rand(chars.size)] }.join
    end
    
    def generate_temp_filename
      Dir.mkdir(temp_path) unless File.exists?(temp_path)
      begin
        filename = File.join(temp_path, generate_random_string)
      end while File.exists?(filename + ".*")
      return filename
    end

    def file_footer(file_name)
      return <<-raw
<?php
  $content = ob_get_clean();
  require_once('#{render_as_pdf_path}');
  $html2pdf = new HTML2PDF('P','A4', 'ca');
  $html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
  $html2pdf->Output('#{file_name}');
?>
      raw
    end
    
  end
end
