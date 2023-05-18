<?php

namespace App\Test\Controller\Accounting;

use App\Entity\Accounting\HoaReportCategory;
use App\Repository\HoaReportCategoryRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HoaReportCategoryControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private HoaReportCategoryRepository $repository;
    private string $path = '/accounting/hoa/report/category/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(HoaReportCategory::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('HoaReportCategory index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'hoa_report_category[category]' => 'Testing',
            'hoa_report_category[ordering]' => 'Testing',
            'hoa_report_category[hoa]' => 'Testing',
        ]);

        self::assertResponseRedirects('/accounting/hoa/report/category/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new HoaReportCategory();
        $fixture->setCategory('My Title');
        $fixture->setOrdering('My Title');
        $fixture->setHoa('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('HoaReportCategory');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new HoaReportCategory();
        $fixture->setCategory('My Title');
        $fixture->setOrdering('My Title');
        $fixture->setHoa('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'hoa_report_category[category]' => 'Something New',
            'hoa_report_category[ordering]' => 'Something New',
            'hoa_report_category[hoa]' => 'Something New',
        ]);

        self::assertResponseRedirects('/accounting/hoa/report/category/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCategory());
        self::assertSame('Something New', $fixture[0]->getOrdering());
        self::assertSame('Something New', $fixture[0]->getHoa());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new HoaReportCategory();
        $fixture->setCategory('My Title');
        $fixture->setOrdering('My Title');
        $fixture->setHoa('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/accounting/hoa/report/category/');
    }
}
