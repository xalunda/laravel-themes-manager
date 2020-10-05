<?php

namespace Hexadog\ThemesManager\Console\Commands;

use Illuminate\Console\Command;

class ListThemes extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'theme:list';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'List all registered themes';

	/**
	 * The table headers for the command.
	 *
	 * @var array
	 */
	protected $headers = ['Default', 'Namespace', 'Extends', 'Vendor', 'Name', 'Description', 'Version', 'Author'];

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Prompt for module's alias name
	 *
	 */
	public function handle()
	{
		$this->themes = [];
		
		$themes = \Theme::all();

		foreach ($themes as $theme) {
			$this->themes[] = [
				'default'		=> $theme->getName() === config('themes-manager.fallback_theme') ? 'X' : '',
				'namespace'		=> $theme->getNamespace(),
				'extends'		=> $theme->getParent() ? $theme->getParent() : '',
				'vendor'		=> $theme->getVendor(),
				'name'			=> $theme->getName(),
				'description'	=> $theme->get('description'),
				'version'		=> $theme->get('version'),
				'author'		=> $theme->get('author')
			];
		}
		
		if (count($this->themes) == 0) {
			return $this->error("Your application doesn't have any theme.");
		}

		$this->table($this->headers, $this->themes);
	}
}