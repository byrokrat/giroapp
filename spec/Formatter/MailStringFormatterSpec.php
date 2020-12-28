<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Formatter;

use byrokrat\giroapp\Formatter\MailStringFormatter;
use byrokrat\giroapp\Formatter\FormatterInterface;
use byrokrat\giroapp\Domain\Donor;
use Symfony\Component\Console\Output\OutputInterface;
use PhpSpec\ObjectBehavior;

class MailStringFormatterSpec extends ObjectBehavior
{
    function let(OutputInterface $output)
    {
        $this->initialize($output);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MailStringFormatter::class);
    }

    function it_is_a_formatter()
    {
        $this->shouldHaveType(FormatterInterface::class);
    }

    function it_can_format_donor(Donor $donor, $output)
    {
        $donor->getName()->willReturn('foo');
        $donor->getEmail()->willReturn('foo@bar');

        $this->formatDonor($donor);

        $this->finalize();

        $output->writeln('foo <foo@bar>')->shouldHaveBeenCalled();
    }

    function it_can_format_donor_with_no_name(Donor $donor, $output)
    {
        $donor->getName()->willReturn('');
        $donor->getEmail()->willReturn('foo@bar');

        $this->formatDonor($donor);

        $this->finalize();

        $output->writeln('foo@bar')->shouldHaveBeenCalled();
    }

    function it_skips_donor_with_no_email(Donor $donor, $output)
    {
        $donor->getName()->willReturn('foo');
        $donor->getEmail()->willReturn('');

        $this->formatDonor($donor);

        $this->finalize();

        $output->writeln('')->shouldHaveBeenCalled();
    }

    function it_can_format_multiple_donor(Donor $foo, Donor $bar, $output)
    {
        $foo->getName()->willReturn('foo');
        $foo->getEmail()->willReturn('foo@bar');

        $bar->getName()->willReturn('');
        $bar->getEmail()->willReturn('bar@foo');

        $this->formatDonor($foo);
        $this->formatDonor($bar);

        $this->finalize();

        $output->writeln('foo <foo@bar>, bar@foo')->shouldHaveBeenCalled();
    }
}
