module RenderAsPdfFunctions

  RenderAsPdfError = Class.new(StandardError)
  def render_as_pdf(*args)
    html = render_to_string(*args)
    render_as_pdf_string(html)
  end

  def render_as_pdf_file(html)
    filename = RenderAsPdf.generate_temp_filename
    php_filename = filename + ".php"
    pdf_filename = filename + ".pdf"
    File.open(php_filename, "wb") do |f|
      f.write(RenderAsPdf.file_header)
      f.write(Iconv.new('ISO-8859-15//IGNORE//TRANSLIT', 'utf-8').iconv(html))
      f.write(RenderAsPdf.file_footer(pdf_filename))
    end
    output = `php "#{php_filename}" > "#{pdf_filename}"`
    unless File.exist?(pdf_filename)
      raise RenderAsPdfError, output
    end
    return pdf_filename
  end

  def render_as_pdf_string(html)
    pdf_filename = render_as_pdf_file(html)
    pdf_string = temp_filename = ""
    File.open(pdf_filename, "rb") do |f|
      pdf_string = f.read
      temp_filename = File.join(File.dirname(f.path), File.basename(pdf_filename, ".*"))
    end
    FileUtils.rm(temp_filename + ".php")
    FileUtils.rm(temp_filename + ".pdf")
    return pdf_string
  end

end
