<?php

namespace AppBundle\Command;

use AppBundle\Dto\API\People\Connections\ListResponseDto;
use Buzz\Browser;
use Buzz\Client\Curl;
use Buzz\Message\Form\FormRequest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetConnectionsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('app:get_connections_command');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $token = 'ya29.a0Ae4lvC1SDe0uORkNQ_nNfN8BjdhbmnFGsyxSZJ470rHiMsmZbtE4btqKQ8fF7H8XlJcrq46AGSEk795dCPqyoJvcJdX7eTN7LHyTQ8ooQZgAXRy-J4TJGfAaxIzcF_m5wk8bfnZqOrfF5WJb5mq__X8DG5cSLiWI34Y5XLH_';

        $browser = new Browser(new Curl());

        $formRequest = new FormRequest(
            FormRequest::METHOD_GET,
            '/v1/people/me/connections',
            'https://people.googleapis.com'
        );
        $formRequest->addFields(['personFields' => 'names']);
        $formRequest->addHeader(sprintf('Authorization: Bearer %s', $token));

        $response = $browser->send($formRequest);

        $content = $response->getContent();

        /** @var ListResponseDto $listResponse */
        $listResponse = $this->getContainer()->get('serializer')->deserialize($content, ListResponseDto::class, 'json');
        $pureResponse = json_decode($content, true);

        if ($listResponse->getConnections()->isEmpty()) {
            $output->writeln('No connections synced.');
            return;
        }

        foreach ($listResponse->getConnections() as $connection) {
            $output->writeln(sprintf('%s auf API gefunden.', $connection->getDisplayName()));
        }
    }
}
