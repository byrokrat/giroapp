<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Xml;

use byrokrat\giroapp\Xml\CustomdataTranslator;
use byrokrat\giroapp\Xml\XmlMandateMigrationInterface;
use byrokrat\giroapp\Builder\DonorBuilder;
use byrokrat\giroapp\Exception\InvalidXmlMandateMigrationException;
use byrokrat\amount\Currency\SEK;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CustomdataTranslatorSpec extends ObjectBehavior
{
    function let(XmlMandateMigrationInterface $migrationMap)
    {
        $migrationMap->getXmlMigrationMap()->willReturn([]);
        $this->beConstructedWith($migrationMap);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CustomdataTranslator::CLASS);
    }

    function it_sets_attribute_if_key_is_not_migrated(DonorBuilder $donorBuilder)
    {
        $this->writeValue($donorBuilder, 'key', 'value');
        $donorBuilder->setAttribute('key', 'value')->shouldHaveBeenCalled();
    }

    function it_throws_exception_on_invalid_migration_map($migrationMap)
    {
        $migrationMap->getXmlMigrationMap()->willReturn(['foo' => 'not-a-callable...']);
        $this->shouldThrow(InvalidXmlMandateMigrationException::CLASS)->duringInstantiation();
    }

    function it_runs_callable_if_defined($migrationMap, DonorBuilder $donorBuilder)
    {
        $migrationMap->getXmlMigrationMap()->willReturn([
            'foo' => function (DonorBuilder $donorBuilder, string $value) {
                $donorBuilder->setAttribute('bar', 'this-is-my-cool-callable-action');
            }
        ]);

        $this->writeValue($donorBuilder, 'foo', 'ignored...');
        $donorBuilder->setAttribute('bar', 'this-is-my-cool-callable-action')->shouldHaveBeenCalled();
    }

    function it_sets_phone_numbers($migrationMap, DonorBuilder $donorBuilder)
    {
        $migrationMap->getXmlMigrationMap()->willReturn(['phone' => XmlMandateMigrationInterface::PHONE]);
        $donorBuilder->setPhone('12345')->shouldBeCalled();
        $this->writeValue($donorBuilder, 'phone', '12345');
    }

    function it_sets_mail_addresses($migrationMap, DonorBuilder $donorBuilder)
    {
        $migrationMap->getXmlMigrationMap()->willReturn(['mail' => XmlMandateMigrationInterface::EMAIL]);
        $donorBuilder->setEmail('foo@bar.com')->shouldBeCalled();
        $this->writeValue($donorBuilder, 'mail', 'foo@bar.com');
    }

    function it_sets_amounts($migrationMap, DonorBuilder $donorBuilder)
    {
        $migrationMap->getXmlMigrationMap()->willReturn(['amount' => XmlMandateMigrationInterface::DONATION_AMOUNT]);
        $donorBuilder->setDonationAmount(new SEK('100'))->shouldBeCalled();
        $this->writeValue($donorBuilder, 'amount', '100');
    }

    function it_sets_comments($migrationMap, DonorBuilder $donorBuilder)
    {
        $migrationMap->getXmlMigrationMap()->willReturn(['comment' => XmlMandateMigrationInterface::COMMENT]);
        $donorBuilder->setComment('foobar')->shouldBeCalled();
        $this->writeValue($donorBuilder, 'comment', 'foobar');
    }
}
