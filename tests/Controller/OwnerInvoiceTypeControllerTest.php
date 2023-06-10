<?php

namespace App\Test\Controller\Accounting;

use App\Entity\Accounting\OwnerInvoiceType;
use App\Repository\Accounting\OwnerInvoiceTypeRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OwnerInvoiceTypeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private OwnerInvoiceTypeRepository $repository;
    private string $path = '/accounting/owner/invoice/type/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(OwnerInvoiceType::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('OwnerInvoiceType index');

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
            'owner_invoice_type[type]' => 'Testing',
            'owner_invoice_type[creditAccount]' => 'Testing',
            'owner_invoice_type[debitAccount]' => 'Testing',
        ]);

        self::assertResponseRedirects('/accounting/owner/invoice/type/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new OwnerInvoiceType();
        $fixture->setType('My Title');
        $fixture->setCreditAccount('My Title');
        $fixture->setDebitAccount('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('OwnerInvoiceType');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new OwnerInvoiceType();
        $fixture->setType('My Title');
        $fixture->setCreditAccount('My Title');
        $fixture->setDebitAccount('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'owner_invoice_type[type]' => 'Something New',
            'owner_invoice_type[creditAccount]' => 'Something New',
            'owner_invoice_type[debitAccount]' => 'Something New',
        ]);

        self::assertResponseRedirects('/accounting/owner/invoice/type/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getCreditAccount());
        self::assertSame('Something New', $fixture[0]->getDebitAccount());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new OwnerInvoiceType();
        $fixture->setType('My Title');
        $fixture->setCreditAccount('My Title');
        $fixture->setDebitAccount('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/accounting/owner/invoice/type/');
    }
}
