<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpClient\Exception\ServerException;

class DoodleSubscribCommand extends Command
{
    protected static $defaultName = 'doodle:subscrib';

    private $path;

    public function __construct($path){
        parent::__construct(self::$defaultName);
        $this->pack=$path;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
        ;
    }

    private static function createRequestContent(string $poll, array $user): array{
        return array(
            'headers'=> array(
                'accept'=> 'application/json, text/javascript, */*; q=0.01',
                'accept-encoding'=> 'gzip, deflate, br',
                'accept-language'=> 'fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7,da;q=0.6',
                'cache-control'=>'no-cache',
                //'sec-fetch-mode'=>'cors',
                'origin'=> 'https://doodle.com',
                'x-requested-with'=> 'XMLHttpRequest',
                'user-agent'=> 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
                'content-type'=>'application/json',
                //'authority'=> 'doodle.com',
                //'sec-fetch-site'=>'same-origin'
            ),
            'extra'=> array(
                'referer'=> 'https://doodle.com/poll/'.$poll,
                "credentials"=> "include",
                "mode"=> "cors",
            ),
           /*'query'=>array(
                'adminKey'=>"9hcpa88d"
            ),*/
            'json'=>array(
                'id'=>isset($user['id'])?$user['id']:null,
                'name'=>$user['firstName']/*.' '.$olivier['lastName']*/,
                'preferences'=> [1,0,0,0,0,0,0],
                /*'firstName'=>$olivier['firstName'],
                'lastName'=>$olivier['lastName'],
                'postalAddress' =>$olivier['postalAddress'],
                'email'=>$olivier['email'],*/
                'optionsHash'=>'e05fba8de85e1db8d5a8f0474cbc9676',
                'participantKey'=> null
            )
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $value = Yaml::parseFile($this->pack);
        
        foreach($value["users"] as $user){
            $options = self::createRequestContent($value['poll_id'],$user);
            $url = $value['doodle_url'].'/polls/'.$value['poll_id'].'/participants'.(isset($user['id'])?'/'.$user['id']:'');
            try{
                $client = new CurlHttpClient($options);
                $response = $client->request(isset($user['id'])?'PUT':'POST',$url);
                if(200 === $response->getStatusCode()){
                    $io->success($user['firstName'].' '.$user['lastName']);
                }else{
                    $io->warning($user['firstName'].' '.$user['lastName']);
                }    
            }catch (ServerException $serverException){
                $io->error($user['firstName'].' '.$user['lastName']);
            }
        }
        return 0;
    }
}
