naut: Deploynaut CLI tool
=========================

[![Build Status](https://travis-ci.org/sminnee/naut-cli.svg?branch=master)](https://travis-ci.org/sminnee/naut-cli)

The `naut` package is a simple CLI tool for interacting with a Deploynaut server

Usage
-----

First, create `~/.naut` with the following information:

    server=http://deploy.example.com
    auth=username:password


Then you can run a number of naut commands:

### `naut projects`

Return a list of project names, 1 per line

### `naut envs <project>`

Return a list of environment names for the given project, 1 per line.

### `naut deploy <project> <env> <sha>`

Deploy the given SHA to the given project on the given environment.

### `naut refresh-vcs <project>`

Refresh the local cache of the code repository for the given project.

## New commands coming soon

These commands haven't been implemented yet...

### `naut envs <project> --full`

Returns more details about

 * Environment name
 * Currently deployed SHA
 * Date/time of last deploy
 * "can-deploy" / "cant-deploy", depending on your permissions

For example:

    staging 51b0744d5a486cef44975f68598aff86adba7ba0 2014-07-07 14:50 can-deploy
    live dc041946d07e6a6d8acac617663a3a2e9486975f 2014-07-07 14:50 cant-deploy

### `naut deploy-history <project> <env>`

Returns a list of deployments to the given envrionment, listing the following data, 1 deploy per line:

 * Deploy ID: a number
 * Status: Queued, Started, Finished, Failed
 * Date (Y-m-d)
 * Time (24h)
 * Git SHA
 * Deployer email address

For example:

    2981 Finished 2014-05-2014 14:30 4a489d9bd8878fd33e3e7aa303ad792b1b1df927 someone@example.com

There is an optional argument, `--limit <num>` to limit the number of rows returned.

### `naut deploy-log <project> <env> <deploy id>`

Returns the complete deployment log of the given deployment. Deploy ID is returned by `naut deploy-history`.

### `naut branches <project>`

Return all the branches in the given project, 1 per line.

### `naut branches <project> --full`

Returns full details about

 * Branch name
 * Last-update date
 * Last-update time

For example:

    1.1 2014-06-06 14:30
    1.0 2014-03-03 12:25

### `naut tags <project>`

Return all the tags in the given project.
