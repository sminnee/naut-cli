naut: Deploynaut CLI tool
=========================

The `naut` package is a simple CLI tool for interacting with a Deploynaut server

Usage
-----

First, create `~/.naut` with the following information:

    server=http://deploy.example.com
    auth=username:password


Then you can run a number of naut commands:

### `naut projects`

Return a list of project names, 1 per line

### `naut envs <project name>`

Return a list of environment names for the given project, 1 per line.

### `naut deploy <project>:<env> <sha>`

Deploy the given SHA to the given project on the given environment.
