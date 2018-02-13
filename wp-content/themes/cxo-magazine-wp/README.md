# CXO Magazine
Wordpress build for [Northeastern CXO](https://www.cxo-magazine.com/)

## Table of Contents

* [References](#references)
* [Setup](#setup)
* [Environment Variables](#environment-variables)
* [DB Migration](#db-migration)
* [Deployment](#deployment)

In-depth documentation on the code and technologies can be found [here](https://github.com/Upstatement/cxo-magazine-wp/wiki)

## References

#### Hosting
- **Development**: [dev-cxo-magazine.pantheonsite.io](http://dev-cxo-magazine.pantheonsite.io)
- **Staging (Test)**: [http://test-cxo-magazine.pantheonsite.io](http://http://test-cxo-magazine.pantheonsite.io)

#### Technologies:
- [Docker](https://www.docker.com/) configuration
- [Yarn](https://yarnpkg.com/en/) to install node modules
- [Composer](https://getcomposer.org/) to install wordpress plugins
- [Gulp](https://gulpjs.com/) for automating build scripts
- [Webpack](https://webpack.js.org/) + [Babel](https://babeljs.io/) for compiling Javascript
- [Smoothstate](https://github.com/miguel-perez/smoothState.js) for page transitions
- [Timber](https://timber.github.io/docs/) for cleaner Wordpress workflow
- [TravisCI](https://travis-ci.com/) for Auto-Deployment to pantheon
- [Pantheon](https://pantheon.io/) for hosting

### Contributing
- Check out our [contribution guidelines](CONTRIBUTING.MD) to see where to start

## Setup

### Prerequisites
- [Node](https://nodejs.org/en/)
- [Yarn](https://yarnpkg.com/en/)
- [Gulp](http://gulpjs.com/) (must be installed globally)
- [Composer](https://getcomposer.org/)
- [Docker for Mac](https://docs.docker.com/docker-for-mac/install/)

### Installation
1.  Clone this project into your `sites` directory and `cd` into it.
2.  Spin up the Docker container:
```
docker-compose up -d
```
3.  Install php dependencies:
```
docker-compose exec wordpress sh -c "cd wp-content/themes/cxo-magazine-wp && composer install"
```
4.  Navigate to `localhost:8081` and follow the prompts (any username/pw is ok).  Once you're logged into the admin, activate the `CXO Magazine` theme.
5.  Install node dependencies:
```
nvm use
yarn
```
6. Build front-end assets and watch for changes:
```
gulp
```
7. Set up [Environment Variables](#environment-variables)
- Make a copy `.env-example`, name it `.env` and add MailChimp API keys
8. Import the [Database](#db-migration)

### Node Dependencies
This project uses es2016 module import syntax. To add a new js dependency:
```
yarn add jquery
```
Then import from within the js file with:
```
import $ from 'jquery';
```

## Environment Variables
Development
- We put API keys in our `.env` file using [phpdotenv](https://github.com/vlucas/phpdotenv)
- The example variables are in `.env-example`

Production
- Environment Variables are defined in wp-config.php on each environment [dev, test, live]
- Documentation can be found [here](https://pantheon.io/docs/wp-config-php/)

## DB Migration
- Enable the "WP Migrate DB Pro" and "WP Migrate DB Pro Media Files" plugins
- Go to Tools -> Migrate DB Pro, Settings tab, and activate with license key:
```
193a18f8-334b-433b-8b7a-39e21b890203
```
- Go to Migrate tab, click Pull, and paste in the following for the Connection Info:
```
https://www.cxo-magazine.com xDCZDot9F+Gt7u7ZF32qNj365i3/VSKnM1qcpsQX
```
- Check the Media Files and Save Migration Profile checkboxes.
- Find and Replace the url
  - `//www.cxo-magazine.com` with `//localhost:8081`
  - `https://localhost:8081` with `http://localhost:8081`
  - `src/bindings/...` with `/var/www/html` (this will be prefilled already, just don't touch it)
- Click Pull Button

## Deployment
Pushes to development are triggered by our Travis CI [configuration](.travis.yml) using the [deploy.sh](deploy.sh) script, which rsync's the theme and plugins to Pantheon.

### Test (Staging) Deployment

Pantheon does not allow for any direct modification to the codebase on Test. All code pushes must be done manually through the Pantheon
control panel.

1. Go to the Dev site dashboard. If this is a sprint deployment, type in the name of the sprint. Click `Code`, and click `Commit`.
1. Go to the Test dashboard and click `Deploy Code form Development to Test Environment`.
