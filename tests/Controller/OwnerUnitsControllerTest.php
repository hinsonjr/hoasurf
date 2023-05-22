<?php

namespace App\Test\Controller;

use App\Entity\UnitOwners;
use App\Repository\UnitOwnersRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UnitOwnersControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private UnitOwnersRepository $repository;
    private string $path = '/owner/units/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(UnitOwners::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('OwnerUnit index');

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
            'owner_unit[startDate]' => 'Testing',
            'owner_unit[endDate]' => 'Testing',
            'owner_unit[ownPercent]' => 'Testing',
            'owner_unit[owner]' => 'Testing',
            'owner_unit[unit]' => 'Testing',
        ]);

        self::assertResponseRedirects('/owner/units/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new UnitOwners();
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setOwnPercent('My Title');
        $fixture->setOwner('My Title');
        $fixture->setUnit('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('OwnerUnit');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new UnitOwners();
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setOwnPercent('My Title');
        $fixture->setOwner('My Title');
        $fixture->setUnit('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'owner_unit[startDate]' => 'Something New',
            'owner_unit[endDate]' => 'Something New',
            'owner_unit[ownPercent]' => 'Something New',
            'owner_unit[owner]' => 'Something New',
            'owner_unit[unit]' => 'Something New',
        ]);

        self::assertResponseRedirects('/owner/units/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getStartDate());
        self::assertSame('Something New', $fixture[0]->getEndDate());
        self::assertSame('Something New', $fixture[0]->getOwnPercent());
        self::assertSame('Something New', $fixture[0]->getOwner());
        self::assertSame('Something New', $fixture[0]->getUnit());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new UnitOwners();
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setOwnPercent('My Title');
        $fixture->setOwner('My Title');
        $fixture->setUnit('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/owner/units/');
    }
}
