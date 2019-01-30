<?php
/**
 * This file is part of byrokrat\giroapp.
 *
 * byrokrat\giroapp is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * byrokrat\giroapp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with byrokrat\giroapp. If not, see <http://www.gnu.org/licenses/>.
 *
 * Copyright 2016-19 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Filesystem\FilesystemInterface;
use byrokrat\giroapp\Exception\InvalidPluginException;
use Symfony\Component\Finder\Finder;

final class FilesystemLoadingPlugin implements PluginInterface
{
    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function loadPlugin(EnvironmentInterface $environment): void
    {
        $finder = (new Finder)
            ->in($this->filesystem->getAbsolutePath(''))
            ->files()
            ->name('*.php')
            ->name('/\.(php)|(phar)$/i')
            ->depth('== 0');

        foreach ($finder as $file) {
            if (in_array($file->getPathname(), get_included_files())) {
                continue;
            }

            $plugin = require $file->getPathname();

            if (!$plugin instanceof PluginInterface) {
                throw new InvalidPluginException("Invalid plugin in {$file->getPathname()}");
            }

            $plugin->loadPlugin($environment);
        }
    }
}
