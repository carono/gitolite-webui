<?php

namespace app\components;

/**
 * Gitolite Class
 *
 * Project:   gitolite-php
 * File:      src/Gitolite/Gitolite.php
 *
 * Copyright (C) 2012 Rafael Goulart
 *
 * This program is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by  the Free
 * Software Foundation; either version 2 of the License, or (at your option)
 * any later version.
 *
 * @author  Rafael Goulart <rafaelgou@gmail.com>
 * @license GNU Lesser General Public License
 * @link    https://github.com/rafaelgou/gitolite-php
 * see CHANGELOG
 */
class Gitolite
{
    protected $gitRemoteRepositoryURL = null;
    protected $gitLocalRepositoryPath = null;
    protected $gitEmail = null;
    protected $gitUsername = null;
    protected $gitServerName = null;
    /**
     * @var PHPGit_Repository
     */
    protected $gitoliteRepository = null;

    protected $users = array();
    /**
     * @var Team[]
     */
    protected $teams = array();
    protected $repos = array();

    protected $log = array();

    const GITOLITE_CONF_FILE = 'gitolite.conf';
    const GITOLITE_CONF_DIR = 'conf/';
    const GITOLITE_KEY_DIR = 'keydir/';
    const GITOLITE_REPO_DIR = 'conf/repos/';

    /**
     * Set GitRemoteRepositoryURL
     *
     * @param string $gitRemoteRepositoryURL The remote repository URL
     *
     * @return Gitolite
     */
    public function setGitRemoteRepositoryURL($gitRemoteRepositoryURL)
    {
        $this->gitRemoteRepositoryURL = (string)$gitRemoteRepositoryURL;
        return $this;
    }

    public function __construct()
    {
        $team = new Team();
        $team->name = 'all';
        $this->addTeam($team);
    }

    /**
     * Get GitRemoteRepositoryURL
     *
     * @return string
     */
    public function getGitRemoteRepositoryURL()
    {
        return $this->gitRemoteRepositoryURL;
    }

    /**
     * Set GitLocalRepositoryPath
     *
     * @param string $gitLocalRepositoryPath The git local repository Path
     *
     * @return Gitolite
     */
    public function setGitLocalRepositoryPath($gitLocalRepositoryPath)
    {
        $this->gitLocalRepositoryPath = (string)$gitLocalRepositoryPath;
        return $this;
    }

    /**
     * Get GitLocalRepositoryPath
     *
     * @return string
     */
    public function getGitLocalRepositoryPath()
    {
        return $this->gitLocalRepositoryPath;
    }

    /**
     * Set GitEmail
     *
     * @param string $gitEmail The git user email
     *
     * @return Gitolite
     */
    public function setGitEmail($gitEmail)
    {
        $this->gitEmail = (string)$gitEmail;
        return $this;
    }

    /**
     * Get GitEmail
     *
     * @return string
     */
    public function getGitEmail()
    {
        return $this->gitEmail;
    }

    /**
     * Set GitUsername
     *
     * @param string $gitUsername The git user name
     *
     * @return User
     */
    public function setGitUsername($gitUsername)
    {
        $this->gitUsername = (string)$gitUsername;
        return $this;
    }

    /**
     * Get GitUsername
     *
     * @return string
     */
    public function getGitUsername()
    {
        return $this->gitUsername;
    }

    /**
     * Set GitServername
     *
     * @param string $gitServername The git server name
     *
     * @return Gitolite
     */
    public function setGitServerName($gitServerName)
    {
        $this->gitServerName = (string)$gitServerName;
        return $this;
    }

    /**
     * Get GitServername
     *
     * @return string
     */
    public function getGitServerName()
    {
        return $this->gitServerName;
    }

    /**
     * Set Repos
     *
     * @param array $repos An array of repositories
     *
     * @return Acl
     */
    public function setRepos(array $repos)
    {
        $this->repos = $repos;
        return $this;
    }

    /**
     * Get Repos
     *
     * @return array of Repos
     */
    public function getRepos()
    {
        return $this->repos;
    }

    /**
     * Get Repo
     *
     * @param string repo name
     *
     * @return mixed object of Repo or false
     */
    public function getRepo($name)
    {
        return (isset($this->repos[$name])) ? $this->repos[$name] : false;
    }

    /**
     * Add repo
     *
     * @param string $repo A repository object
     *
     * @return Acl
     */
    public function addRepo(Repo $repo)
    {
        $name = $repo->getName();
        $this->repos[$name] = $repo;
        return $this;
    }

    /**
     * Delete repo
     *
     * @param string repo name
     *
     */
    public function delRepo($name)
    {
        unset($this->repos[$name]);
    }

    /**
     * Set Users
     *
     * @param array $users An array of user objects
     *
     * @return Acl
     */
    public function setUsers(array $users)
    {
        $this->users = array();
        foreach ($users as $user) {
            $this->addUser($user);
        }
        return $this;
    }

    /**
     * Get Users
     *
     * @return array of Users
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Get User
     *
     * @param string username
     *
     * @return mixed object of User or false
     */
    public function getUser($username)
    {
        return (isset($this->users[$username])) ? $this->users[$username] : false;
    }

    /**
     * Add user
     *
     * @param string $user A user object
     *
     * @return Acl
     */
    public function addUser(User $user)
    {
        $username = $user->getUsername();
        $this->users[$username] = $user;
        return $this;
    }

    /**
     * Set Teams
     *
     * @param array $teams An array of team objects
     *
     * @return Acl
     */
    public function setTeams(array $teams)
    {
        $this->teams = array();
        foreach ($teams as $team) {
            $this->addTeam($team);
        }
        return $this;
    }

    /**
     * Get Teams
     *
     * @return array of Teams
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Get Team
     *
     * @param string team name
     *
     * @return Team
     */
    public function getTeam($name)
    {
        $name = trim($name, '@ ');
        return (isset($this->teams[$name])) ? $this->teams[$name] : false;
    }

    /**
     * Add Team
     *
     * @param string $team A team object
     *
     * @return Acl
     */
    public function addTeam(Team $team)
    {
        $this->teams[$team->name] = $team;
        return $this;
    }

    private function parseUsers($line)
    {
        /*
                $usr = preg_split("/[\s\t]+/", $line);
                foreach ($usr as $u) {
                    // is team
                    if (substr($u, 0, 1) == '@') {
                        $u = substr($u, 1);
                        if (!isset($this->teams[$u])) {
                            GitoliteException::trowUndefinedTeam($u);
                        }
                        $team->addTeam($this->teams[$u]);
                    } else {
                        // is user
                        if (isset($this->users[$u])) {
                            $team->addUser($this->users[$u]);
                        } else {
                            $user = new User();
                            $user->setUsername($u);
                            $key = $this->getGitLocalRepositoryPath() . DIRECTORY_SEPARATOR . self::GITOLITE_KEY_DIR
                                . DIRECTORY_SEPARATOR . $user->renderKeyFileName();
                            if (file_exists($key)) {
                                $user->addKey(file_get_contents($key));
                            }
                            $this->users[$u] = $user;
                            $team->addUser($user);
                        }
                    }
                }
        */
    }

    protected static function isTeam($string)
    {
        return preg_match('/^[@]/', $string);
    }

    protected function parseTeam($line)
    {
        $arr = preg_split("/[=]+/", $line, 2);
        if (count($arr) != 2) {
            GitoliteException::throwInvalidTeam($line);
        }
        $name = trim($arr[0], "@ ");
        if (!$team = $this->getTeam($name)) {
            $team = new Team();
            $team->name = $name;
            $this->teams[$team->name] = $team;
        }
        foreach (array_filter(preg_split("/[\s\t]+/", $arr[1])) as $name) {
            if (self::isTeam($name)) {
                $team->addObjects($this->getTeamObjects($name));
            } else {
                $object = new Object();
                $object->name = $name;
                $team->addObject($object);
            }
        }
    }

    public function getTeamObjects($name)
    {
        $name = trim($name, "@ ");
        if (!isset($this->teams[$name])) {
            GitoliteException::throwUndefinedTeam($name);
        }
        return $this->teams[$name]->items;
    }

    private function parseRule($line)
    {
        $arr = preg_split("/[=]+/", $line, 2);
        if (count($arr) != 2) {
            GitoliteException::throwInvalidRule($line);
        }
        $acl_split = preg_split("/[\s\t]+/", trim($arr[0]), 2);
        $refexes = (isset($acl_split[1])) ? $acl_split[1] : false;
        $acl = new Acl();
        $acl->setPermission($acl_split[0]);
        if ($refexes) {
            $acl->setRefexes($refexes);
        }
        $users = preg_split("/[\s\t]+/", trim($arr[1]));
        foreach ($users as $user) {
            if (self::isTeam($user)) {
                if (!$this->getTeam($user)) {
                    GitoliteException::throwUndefinedTeam($user);
                }
                $acl->addTeam($this->getTeamAsUser($user));
            } else {
                if (!$userModel = $this->getUser($user)) {
                    $userModel = new User();
                    $userModel->setName($user);
                    $this->addUser($userModel);
                }
                $acl->addUser($userModel);
            }
        }
        return $acl;
    }

    public function getTeamAs($name, $type, $class)
    {
        if ($team = $this->getTeam($name)) {
            if ($team->type && $team->type != $type) {
                GitoliteException::throwWrongTeamType($name, $type);
            }
            if (!$team->type) {
                $arr = [];
                foreach ($team->items as $item) {
                    $object = new $class;
                    $object->setName($item->name);
                    $arr[] = $object;
                }
                $team->items = $arr;
                $team->type = $type;
            }
        }
        return $team;
    }

    public function getTeamAsUser($name)
    {
        return $this->getTeamAs($name, Team::USERS, 'app\components\User');
    }

    public function getTeamAsRepo($name)
    {
        return $this->getTeamAs($name, Team::REPO, 'app\components\Repo');
    }

    /**
     * @param $line
     *
     * @return Repo[]
     * @throws GitoliteException
     */
    protected function parseRepo($line)
    {
        $find = [];
        $arr = preg_split("/[\s\t]+/", $line);
        array_shift($arr);
        foreach ($arr as $name) {
            if (self::isTeam($name)) {
                if (!$team = $this->getTeamAsRepo($name)) {
                    GitoliteException::throwUndefinedTeam($name);
                }
                $find = array_merge($find, $team->items);
            } else {
                $repo = new Repo();
                $repo->setName($name);
                $this->addRepo($repo);
                $find[] = $repo;
            }
        }
        return $find;
    }

    public function import($conf)
    {
        $file = file($conf);
        $this->setGitLocalRepositoryPath(dirname(dirname($conf)));
        $repos = null;
        foreach ($file as $line) {
            $line = trim(preg_replace('/#.*/', '', $line));
            if ($line == '') {
                continue;
            }
            if (preg_match('/^[@]/', $line)) {
                $this->parseTeam($line);
                $repos = null;
            } elseif (preg_match('/^repo/', $line)) {
                $repos = $this->parseRepo($line);
            } elseif (preg_match('/^(R|RW|RW\+|\-|RWC|RW\+C|RWD|RW\+D|RWCD|RW\+CD|RWDC|RW\+DC)/', $line)) {
                if (!$repos) {
                    GitoliteException::throwInvalidSyntax('rules set without repo');
                }
                $rule = $this->parseRule($line);
                foreach ($repos as $repo) {
                    $repo->addAcl($rule);
                }
            }
        }
    }

    /**
     * Get PHPGit_Repository
     *
     * @return PHPGit_Repository
     */
//    protected function getGitoliteRepository()
//    {
//        if (null === $this->gitoliteRepository) {
//            if (null === $this->getGitLocalRepositoryPath()) {
//                throw new \Exception('Git local repository path not defined');
//            }
//            try {
//                $this->gitoliteRepository = new \PHPGit_Repository($this->getGitLocalRepositoryPath());
//            } catch (\Exception $exc) {
//
//                if (file_exists($this->getGitLocalRepositoryPath())) {
//                    throw new \Exception(
//                        "Directory {$this->getGitLocalRepositoryPath()} already exists, impossible to create repository"
//                    );
//                } else {
//                    if (mkdir($this->getGitLocalRepositoryPath(), 0770)) {
//                        $this->gitoliteRepository = \PHPGit_Repository::create($this->getGitLocalRepositoryPath());
//                    } else {
//                        throw new \Exception(
//                            'Impossible to create Directory informed in Git local repository (possibly).'
//                        );
//                    }
//                }
//            }
//        }
//        return $this->gitoliteRepository;
//    }

    /**
     * Write a File down to disk
     *
     * @param string  $filename    The file to be write to disk
     * @param string  $data        The content to be write
     * @param boolean $checkChange Wheter check or not if data is changed
     *
     * @return string
     */
//    protected function writeFile($filename, $data, $checkChange = true)
//    {
//        if (!file_exists($filename)) {
//            if (!file_put_contents($filename, $data)) {
//                throw new \Exception("Impossible to write file {$filename}", 1);
//            }
//        } else {
//            if (!$checkChange) {
//                if (!file_put_contents($filename, $data)) {
//                    throw new \Exception("Impossible to write file {$filename}", 1);
//                }
//            } else {
//                if ($data != file_get_contents($filename)) {
//                    file_put_contents($filename, $data);
//                }
//                return true;
//            }
//        }
//    }

    /**
     * Push configuration to Gitolite Server
     *
     * @return void
     */
//    public function pushConfig()
//    {
//        $cmds[] = 'push gitoliteorigin master';
//        $this->runGitCommand($cmds);
//    }

    /**
     * Commits changes in configuration
     *
     * @return void
     */
//    public function commitConfig()
//    {
//        $status = $this->runGitCommand('status');
//
//        if (!preg_match('/nothing to commit/', $status)) {
//            $cmds[] = 'add .';
//
//            preg_match_all('/deleted:[\s]+(.+)/', $status, $matches);
//            if (isset($matches[1]) && is_array($matches[1])) {
//                foreach ($matches[1] as $v) {
//                    $cmds[] = 'rm ' . $v;
//                }
//            }
//
//            $cmds[] = 'commit -m "Update configuration from ' . $this->getGitServerName() . ' on ' . date('Y-m-d H:i:s')
//                . '"';
//            $this->runGitCommand($cmds);
//            return true;
//        }
//        return false;
//    }

    /**
     * Write full conf file to disk
     *
     * @return void
     */
//    public function writeFullConfFile()
//    {
//        return $this->writeFile(
//            $this->getGitLocalRepositoryPath() . DIRECTORY_SEPARATOR . self::GITOLITE_CONF_DIR
//            . self::GITOLITE_CONF_FILE, $this->renderFullConfFile()
//        );
//    }

    /**
     * Write users keys to disk
     *
     * @return void
     */
//    public function writeUsers()
//    {
//         delete old keys
//        exec('rm ' . $this->getGitLocalRepositoryPath() . DIRECTORY_SEPARATOR . self::GITOLITE_KEY_DIR . '*.pub');
//
//        foreach ($this->getUsers() as $user) {
//            $this->writeFile(
//                $this->getGitLocalRepositoryPath() . DIRECTORY_SEPARATOR . self::GITOLITE_KEY_DIR
//                . $user->renderKeyFileName(), $user->getFirstKey()
//            );
//        }
//    }

    /**
     * Write everything to the disk, commit and push
     *
     * @return void
     */
//    public function writeAndPush()
//    {
//        $this->gitConfig();
//        $this->writeFullConfFile();
//        $this->writeUsers();
//        if ($this->commitConfig()) {
//            $this->pushConfig();
//        }
//    }

    /**
     * Return full conf file
     *
     * @return string
     */
//    public function renderFullConfFile()
//    {
//        return $this->renderUserAndTeams() . $this->renderRepos();
//    }

    /**
     * Return user and teams for conf file
     *
     * @return string
     */
//    public function renderUserAndTeams()
//    {
//        $return = '';
//        foreach ($this->getTeams() as $team) {
//            $return .= $team->render();
//        }
//        return $return . PHP_EOL;
//    }

    /**
     * Return repos for conf file
     *
     * @return string
     */
//    public function renderRepos()
//    {
//        $return = '';
//        foreach ($this->getRepos() as $repo) {
//            $return .= $repo->render();
//        }
//        return $return;
//    }

    /**
     * Configure the repository
     *
     * @return void
     */
//    public function gitConfig()
//    {
//        $cmds[] = sprintf('config user.name "%s"', $this->getGitUsername());
//        $cmds[] = sprintf('config user.email "%s"', $this->getGitEmail());
//        $remotes = $this->runGitCommand('remote -v');
//        $gitoliteRemote = sprintf('gitoliteorigin	%s', $this->getGitRemoteRepositoryURL());
//        if (!preg_match('/' . preg_quote($gitoliteRemote, '/') . '/', $remotes)) {
//            if (preg_match('/gitoliteorigin/', $remotes)) {
//                $cmds[] = 'remote rm gitoliteorigin';
//            }
//            $cmds[] = 'remote add ' . $gitoliteRemote;
//        }
//        $cmds[] = 'pull gitoliteorigin master';
//        $this->runGitCommand($cmds);
//    }

    /**
     * Run git commands
     *
     * @param mixed $cmds A command or an array of commands
     *
     * @return string
     */
//    protected function runGitCommand($cmds = '')
//    {
//        if (!is_string($cmds) && !is_array($cmds)) {
//            return false;
//        }
//
//        if (!is_array($cmds)) {
//            $cmds = array($cmds);
//        }
//
//        foreach ($cmds as $cmd) {
//            try {
//                $date = date('Y-m-d H:i:s');
//                $output = $this->getGitoliteRepository()->git($cmd);
//                $this->log("$date COMMAND RUN: git $cmd");
//                $this->log("$date OUTPUT : . $output");
//            } catch (\GitRuntimeException $e) {
//                $this->log_error("$date GIT ERROR: " . $e->getMessage());
//            } catch (\Exception $e) {
//                $this->log_error("$date ERROR: " . $e->getMessage());
//            }
//        }
//        return $output;
//    }

    /**
     * Log a message
     *
     * @param type $message The message to log
     *
     * @return void
     */
//    protected function log($message)
//    {
//        $this->log['info'][] = $message;
//    }

    /**
     * Log a error message
     *
     * @param type $message The message to log
     *
     * @return void
     */
//    protected function log_error($message)
//    {
//        $this->log['error'][] = $message;
//    }

    /**
     * Get the log
     *
     * @return array
     */
//    public function getLog()
//    {
//        return $this->log;
//    }

    /**
     * Get the log as string
     *
     * @param  string    type = info or error
     *
     * @return string
     */
//    public function getLogAsString($type = 'info')
//    {
//        if (!isset($this->log[$type])) {
//            return false;
//        }
//        return implode(PHP_EOL, $this->log[$type]);
//    }

}
