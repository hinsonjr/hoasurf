<?php

namespace App\Test\Controller;

use App\Entity\Request;
use App\Repository\RequestRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RequestControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private RequestRepository $repository;
    private string $path = '/request/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Request::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Request index');

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
            'request[createdDate]' => 'Testing',
            'request[completedDate]' => 'Testing',
            'request[notes]' => 'Testing',
            'request[type]' => 'Testing',
            'request[createdBy]' => 'Testing',
            'request[assignedTo]' => 'Testing',
            'request[completedBy]' => 'Testing',
            'request[status]' => 'Testing',
        ]);

        self::assertResponseRedirects('/request/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Request();
        $fixture->setCreatedDate('My Title');
        $fixture->setCompletedDate('My Title');
        $fixture->setNotes('My Title');
        $fixture->setType('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setAssignedTo('My Title');
        $fixture->setCompletedBy('My Title');
        $fixture->setStatus('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Request');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Request();
        $fixture->setCreatedDate('My Title');
        $fixture->setCompletedDate('My Title');
        $fixture->setNotes('My Title');
        $fixture->setType('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setAssignedTo('My Title');
        $fixture->setCompletedBy('My Title');
        $fixture->setStatus('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'request[createdDate]' => 'Something New',
            'request[completedDate]' => 'Something New',
            'request[notes]' => 'Something New',
            'request[type]' => 'Something New',
            'request[createdBy]' => 'Something New',
            'request[assignedTo]' => 'Something New',
            'request[completedBy]' => 'Something New',
            'request[status]' => 'Something New',
        ]);

        self::assertResponseRedirects('/request/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCreatedDate());
        self::assertSame('Something New', $fixture[0]->getCompletedDate());
        self::assertSame('Something New', $fixture[0]->getNotes());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
        self::assertSame('Something New', $fixture[0]->getAssignedTo());
        self::assertSame('Something New', $fixture[0]->getCompletedBy());
        self::assertSame('Something New', $fixture[0]->getStatus());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Request();
        $fixture->setCreatedDate('My Title');
        $fixture->setCompletedDate('My Title');
        $fixture->setNotes('My Title');
        $fixture->setType('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setAssignedTo('My Title');
        $fixture->setCompletedBy('My Title');
        $fixture->setStatus('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/request/');
    }
}
