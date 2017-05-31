<?php

/*
 * SessionDB implements SessionHandlerInterface
 */

class SessionDB implements SessionHandlerInterface
{
    private $link;

    /**
     * @param int $save_path
     * @param string $name
     * @return bool
     */
    public function open($save_path, $name)
    {
        $app = \App::getConfig()['db'];
        $link = new Database($app['type'], $app['host'], $app['dbname'], $app['user'], $app['password']);;
        if ($link) {
            $this->link = $link;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function close()
    {
        mysqli_close($this->link);
        return true;
    }

    /**
     * @param string $session_id
     * @return bool
     */
    public function read($session_id)
    {
        $result = mysqli_query($this->link, "SELECT 	Session_Data FROM session_tb WHERE
            Session_Id = '" . $session_id . "' AND Session_Expires > '" . date('Y-m-d H:i:s') . "'");
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['Session_Data'];
        } else {
            return "";
        }
    }

    /**
     * @param string $session_id
     * @param string $session_data
     * @return bool
     */
    public function write($session_id, $session_data)
    {
        $DateTime = date('Y-m-d H:i:s');
        $NewDateTime = date('Y-m-d H:i:s', strtotime($DateTime . ' + 1 hour'));
        $result = mysqli_query($this->link, "REPLACE INTO session_tb SET Session_Id = '" . $session_id . "', 
        Session_Data ='" . $session_data . "',Session_Expires = '" . $NewDateTime . "'");
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $session_id
     * @return bool
     */
    public function destroy($session_id)
    {
        $result = mysqli_query($this->link, "DELETE FROM session_tb WHERE Session_Id ='" . $session_id . "'");
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $maxlifetime
     * @return bool
     */
    public function gc($maxlifetime)
    {
        $result = mysqli_query($this->link,
            "DELETE FROM session_tb WHERE ((UNIX_TIMESTAMP(Session_Expires) + " . $maxlifetime . ") < " . $maxlifetime . ")");
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function override_id($para)
    {
        return $para = $this->id;
    }

}