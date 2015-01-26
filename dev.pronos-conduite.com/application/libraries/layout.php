<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Layout
{
	private $theme = 'default';
	private $title = 'Pronos-conduite';
    private $CI;
    private $var = array();
	
	private $css_dir = 'assets/css/';
	private $js_dir = 'assets/javascript/';
	private $theme_dir = 'application/themes/';
	
	
    public function __construct()
    {
		$this->CI =& get_instance();
		$this->var['output'] = '';
		//titre compos� du nom de la m�thode et du nom du contr�leur
		$this->var['title'] = $this->title . ' | ';
		//variable $charset avec la m�me valeur que la cl� de 
		//configuration initialis�e dans le fichier config.php
		$this->var['charset'] = $this->CI->config->item('charset');
		$this->var['expires'] = gmdate('D, d M Y H:i:s \G\M\T', time() + 7200);
		$this->var['css'] = array();
		$this->var['js'] = array();
		$this->var['context'] = '';
    }
    
	
    public function view($name, $data = array())
    {
        $this->var['output'] .= $this->CI->load->view($name, $data, true);
        $this->CI->load->view('../themes/' . $this->theme, $this->var);
    }
    
	
    public function views($name, $data = array())
    {
        $this->var['output'] .= $this->CI->load->view($name, $data, true);
        return $this;
    }
	
	
	public function set_title($title)
	{
		if(is_string($title) && !empty($title)) {
			$this->var['title'] = $this->var['title'] . $title;
			return true;
		}
		return false;
	}
	
	
	public function set_charset($charset)
	{
		if(is_string($charset) && !empty($charset)) {
			$this->var['charset'] = $charset;
			return true;
		}
		return false;
	}
	
	
	public function add_css($css)
	{
		$file = './' . $this->css_dir . $css . '.css';
		if(is_string($css) && !empty($css) && file_exists($file)) {
			$this->var['css'][] = base_url() . $this->css_dir . $css . '.css';
			return true;
		}
		return false;
	}
 
 
	public function add_js($js)
	{
		$file = './' . $this->js_dir . $js . '.js';
		if(is_string($js) && !empty($js) && file_exists($file)) {
			$this->var['js'][] = base_url() . $this->js_dir . $js . '.js';
			return true;
		}
		return false;
	}
	
	
	public function set_theme($theme)
	{
		$file = './' . $this->theme_dir . $theme . '.php';
		if(is_string($theme) && !empty($theme) && file_exists($file)) {
			$this->theme = $theme;
			return true;
		}
		return false;
	}
	
	public function set_context($context)
	{
		$this->var['context'] = $context;
	}
}