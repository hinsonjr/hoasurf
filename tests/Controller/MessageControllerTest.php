<?php

namespace App\Test\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MessageControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private MessageRepository $repository;
    private string $path = '/message/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Message::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Message index');

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
            'message[subject]' => 'Testing',
            'message[body]' => 'Testing',
            'message[expiration]' => 'Testing',
            'message[createdOn]' => 'Testing',
            'message[type]' => 'Testing',
            'message[category]' => 'Testing',
            'message[createdBy]' => 'Testing',
        ]);

        self::assertResponseRedirects('/message/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Message();
        $fixture->setSubject('My Title');
        $fixture->setBody('My Title');
        $fixture->setExpiration('My Title');
        $fixture->setCreatedOn('My Title');
        $fixture->setType('My Title');
        $fixture->setCategory('My Title');
        $fixture->setCreatedBy('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Message');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Message();
        $fixture->setSubject('My Title');
        $fixture->setBody('My Title');
        $fixture->setExpiration('My Title');
        $fixture->setCreatedOn('My Title');
        $fixture->setType('My Title');
        $fixture->setCategory('My Title');
        $fixture->setCreatedBy('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'message[subject]' => 'Something New',
            'message[body]' => 'Something New',
            'message[expiration]' => 'Something New',
            'message[createdOn]' => 'Something New',
            'message[type]' => 'Something New',
            'message[category]' => 'Something New',
            'message[createdBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/message/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getSubject());
        self::assertSame('Something New', $fixture[0]->getBody());
        self::assertSame('Something New', $fixture[0]->getExpiration());
        self::assertSame('Something New', $fixture[0]->getCreatedOn());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getCategory());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Message();
        $fixture->setSubject('My Title');
        $fixture->setBody('My Title');
        $fixture->setExpiration('My Title');
        $fixture->setCreatedOn('My Title');
        $fixture->setType('My Title');
        $fixture->setCategory('My Title');
        $fixture->setCreatedBy('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/message/');
    }
}
