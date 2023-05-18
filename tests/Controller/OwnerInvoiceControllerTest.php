<?php

namespace App\Test\Controller\Accounting;

use App\Entity\Accounting\OwnerInvoice;
use App\Repository\Accounting\OwnerInvoiceRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OwnerInvoiceControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private OwnerInvoiceRepository $repository;
    private string $path = '/accounting/owner/invoice/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(OwnerInvoice::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('OwnerInvoice index');

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
            'owner_invoice[dueDate]' => 'Testing',
            'owner_invoice[paidDate]' => 'Testing',
            'owner_invoice[effectiveDate]' => 'Testing',
            'owner_invoice[transaction]' => 'Testing',
            'owner_invoice[owner]' => 'Testing',
            'owner_invoice[hoa]' => 'Testing',
        ]);

        self::assertResponseRedirects('/accounting/owner/invoice/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new OwnerInvoice();
        $fixture->setDueDate('My Title');
        $fixture->setPaidDate('My Title');
        $fixture->setEffectiveDate('My Title');
        $fixture->setTransaction('My Title');
        $fixture->setOwner('My Title');
        $fixture->setHoa('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('OwnerInvoice');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new OwnerInvoice();
        $fixture->setDueDate('My Title');
        $fixture->setPaidDate('My Title');
        $fixture->setEffectiveDate('My Title');
        $fixture->setTransaction('My Title');
        $fixture->setOwner('My Title');
        $fixture->setHoa('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'owner_invoice[dueDate]' => 'Something New',
            'owner_invoice[paidDate]' => 'Something New',
            'owner_invoice[effectiveDate]' => 'Something New',
            'owner_invoice[transaction]' => 'Something New',
            'owner_invoice[owner]' => 'Something New',
            'owner_invoice[hoa]' => 'Something New',
        ]);

        self::assertResponseRedirects('/accounting/owner/invoice/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDueDate());
        self::assertSame('Something New', $fixture[0]->getPaidDate());
        self::assertSame('Something New', $fixture[0]->getEffectiveDate());
        self::assertSame('Something New', $fixture[0]->getTransaction());
        self::assertSame('Something New', $fixture[0]->getOwner());
        self::assertSame('Something New', $fixture[0]->getHoa());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new OwnerInvoice();
        $fixture->setDueDate('My Title');
        $fixture->setPaidDate('My Title');
        $fixture->setEffectiveDate('My Title');
        $fixture->setTransaction('My Title');
        $fixture->setOwner('My Title');
        $fixture->setHoa('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/accounting/owner/invoice/');
    }
}
