<?php

namespace App\Test\Controller;

use App\Entity\Owner;
use App\Repository\OwnerRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OwnerControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private OwnerRepository $repository;
    private string $path = '/owner/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Owner::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Owner index');

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
            'owner[name]' => 'Testing',
            'owner[startDate]' => 'Testing',
            'owner[endDate]' => 'Testing',
            'owner[address]' => 'Testing',
            'owner[address2]' => 'Testing',
            'owner[city]' => 'Testing',
            'owner[state]' => 'Testing',
            'owner[zip]' => 'Testing',
            'owner[phone]' => 'Testing',
            'owner[country]' => 'Testing',
            'owner[ownPercent]' => 'Testing',
            'owner[email]' => 'Testing',
            'owner[user]' => 'Testing',
            'owner[units]' => 'Testing',
        ]);

        self::assertResponseRedirects('/owner/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Owner();
        $fixture->setName('My Title');
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setAddress('My Title');
        $fixture->setAddress2('My Title');
        $fixture->setCity('My Title');
        $fixture->setState('My Title');
        $fixture->setZip('My Title');
        $fixture->setPhone('My Title');
        $fixture->setCountry('My Title');
        $fixture->setOwnPercent('My Title');
        $fixture->setEmail('My Title');
        $fixture->setUser('My Title');
        $fixture->setUnits('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Owner');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Owner();
        $fixture->setName('My Title');
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setAddress('My Title');
        $fixture->setAddress2('My Title');
        $fixture->setCity('My Title');
        $fixture->setState('My Title');
        $fixture->setZip('My Title');
        $fixture->setPhone('My Title');
        $fixture->setCountry('My Title');
        $fixture->setOwnPercent('My Title');
        $fixture->setEmail('My Title');
        $fixture->setUser('My Title');
        $fixture->setUnits('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'owner[name]' => 'Something New',
            'owner[startDate]' => 'Something New',
            'owner[endDate]' => 'Something New',
            'owner[address]' => 'Something New',
            'owner[address2]' => 'Something New',
            'owner[city]' => 'Something New',
            'owner[state]' => 'Something New',
            'owner[zip]' => 'Something New',
            'owner[phone]' => 'Something New',
            'owner[country]' => 'Something New',
            'owner[ownPercent]' => 'Something New',
            'owner[email]' => 'Something New',
            'owner[user]' => 'Something New',
            'owner[units]' => 'Something New',
        ]);

        self::assertResponseRedirects('/owner/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getStartDate());
        self::assertSame('Something New', $fixture[0]->getEndDate());
        self::assertSame('Something New', $fixture[0]->getAddress());
        self::assertSame('Something New', $fixture[0]->getAddress2());
        self::assertSame('Something New', $fixture[0]->getCity());
        self::assertSame('Something New', $fixture[0]->getState());
        self::assertSame('Something New', $fixture[0]->getZip());
        self::assertSame('Something New', $fixture[0]->getPhone());
        self::assertSame('Something New', $fixture[0]->getCountry());
        self::assertSame('Something New', $fixture[0]->getOwnPercent());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getUnits());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Owner();
        $fixture->setName('My Title');
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setAddress('My Title');
        $fixture->setAddress2('My Title');
        $fixture->setCity('My Title');
        $fixture->setState('My Title');
        $fixture->setZip('My Title');
        $fixture->setPhone('My Title');
        $fixture->setCountry('My Title');
        $fixture->setOwnPercent('My Title');
        $fixture->setEmail('My Title');
        $fixture->setUser('My Title');
        $fixture->setUnits('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/owner/');
    }
}
