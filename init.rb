require "render_as_pdf"
require "render_as_pdf_functions"

ActionController::Base.send(:include, RenderAsPdfFunctions)
