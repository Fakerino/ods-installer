<?php

namespace ODSInstaller;

use Composer\Installer\LibraryInstaller;
use Composer\Installer\InstallerInterface;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;
use Composer\Repository\VcsRepository;
use Composer\Package\Package;
use Composer\Config;

class FakerinoInstaller extends LibraryInstaller implements InstallerInterface
{

    const ODS_DEFAULT_PATH = 'data';
    const ODS_REPO_URL = 'https://github.com/niklongstone/open-data-sample';

    public function supports($packageType)
    {
        return 'fakerino' === $packageType;
    }

    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);

        return $this->installODS($repo, $package);
    }

    protected function installODS(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        @mkdir(self::ODS_DEFAULT_PATH, 0000);

        $io = new \Composer\IO\BufferIO();
        $downloader = new \Composer\Downloader\GitDownloader($io, new \Composer\Config());
        $odsPackager = new \Composer\Package\Package('ods', 'master', 'master');
        $odsPackager->setSourceUrl('https://github.com/niklongstone/open-data-sample.git');
        $odsPackager->setSourceReference('master');
        $downloader->download($odsPackager, self::ODS_DEFAULT_PATH);

        return $this;
    }

    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        parent::update($repo, $initial, $target);
    }
}