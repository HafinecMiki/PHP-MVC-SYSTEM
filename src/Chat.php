<?php 
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require dirname(__DIR__) . "/db/User.php";
require dirname(__DIR__) . "/db/ChatRooms.php";

class Chat implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        echo "Server Started \n";
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        echo "Server Started \n";

        $this->clients->attach($conn);

        $querystring = $conn->httpRequest->getUri()->getQuery();

        parse_str($querystring, $queryarray);

        if (isset($queryarray['token'])) {

            $user_object = new \User;

            $user_object->setUserToken($queryarray['token']);

            $user_data = $user_object->get_user_id_from_token();

            $user_id = $user_data['user_id'];

            $data['user_id_status'] = $user_id;

            // first, you are sending to all existing users message of 'new'
            foreach ($this->clients as $client) {
                $client->send(json_encode($data)); //here we are sending a status-message
            }
        }

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );

        $data = json_decode($msg, true);

        $chat_object = new \ChatRooms;

        $chat_object->setUserId($data['userId']);

        $chat_object->setMessage($data['msg']);

        $chat_object->save_chat();

        $user_object = new \User;

        $user_object->setUserId($data['userId']);

        $user_data = $user_object->get_user_data_by_id();

        $user_name = $user_data['user_name'];

        $data['dt'] = date("d-m-Y h:i:s");


        foreach ($this->clients as $client) {

            if ($from == $client) {
                $data['from'] = 'Me';
            } else {
                $data['from'] = $user_name;
            }

            $client->send(json_encode($data));
        }
    }

    public function onClose(ConnectionInterface $conn)
    {

        $querystring = $conn->httpRequest->getUri()->getQuery();

        parse_str($querystring, $queryarray);

        if (isset($queryarray['token'])) {

            $user_object = new \User;

            $user_object->setUserToken($queryarray['token']);

            $user_data = $user_object->get_user_id_from_token();

            $user_id = $user_data['user_id'];

            $data['status_type'] = 'Offline';

            $data['user_id_status'] = $user_id;

            foreach ($this->clients as $client) {
                $client->send(json_encode($data));
            }
        }
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
?>