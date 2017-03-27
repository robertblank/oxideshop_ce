# Change Log for 6.0.0

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

### Added
- ESDEV-4354 Add class NamespaceInformationProvider and test

### Changed
- PR 550: replace intval with typecast
- PR 551: less code and only one return statement
- PR 555: Removed a commented debugging line
- ESDEV-4352 Use virtual namespace classes only when generating module chain (aModules).
- ESDEV-4353 Extract new method ModuleChainsGenerator::getActiveChain from ModuleChainsGenerator::createClassChain
- ESDEV-4353 Adapt test to latest changes in class aliasing
- ESDEV-4354 Update ModuleMetadataValidator to validate extend section.
- ESDEV-4354 Adapt module inheritance tests to latest changes
- Stabilize acceptance tests in group quarantine
- ESDEV-4360 Generate ide helper after composer install/update
- Move acceptance test code from EE to CE
- Update Acceptance/Admin/ModuleTest
- ESDEV-3589 Refactor Shop tests to be less fragile
- ESDEV-3589 Add classes for order_list so test could rely on them
- ESDEV-3589 Do not check errors for missing translations for testNewLanguageCreatingAndNavigation
- ESDEV-3589 Uncomment line which checks for error message
- Extract duplicated order information to a separate file

### Deprecated
- ESDEV-4352 Deprecate Config::parseModuleChains(), introduce ModuleList::parseModuleChains()

### Removed
- ESDEV-4354 Remove unused internal classes

### Fixed

### Security



## [6.0-beta3] - 2017-03-14

### Added
- Flow Theme version 2.1.0 - new block: checkout_order_btn_submit_bottom

### Changed
- update of some third party libraries
- controller routing in modules is back and forwards compatible
- virtual namespaces are now everywhere usable with instanceof
- virtual namespaces type hints and exceptions are now backwards and forwards compatible
- Flow Theme version 2.1.0 - renamed block: dd_widget_header_categorylist_navbar_list to dd_widget_header_categorylist_navbar in in widget/header/categorylist.tpl

### Deprecated

### Removed

### Fixed

### Security
- security improvement added a white list for former forbidden user updates



## [6.0-beta2] - 2017-12-13

### Added
- PR 513: New block in admin, containing the table with the modules list
- ESDEV-4183 Add namespaced modules tests

### Changed
- PR 508: Fix php warning
- PR 512: fixed typo in comment
- Make config error visible in CLI
- 0006547 Add original class without namespace to a chain
- PR 506: fixed some DocBlocks
- PR 505: fixed some phpcs errors
- PR 515: cyclomatic complexity improvements
- PR 518: added php 7.1 to php-version matrix in travis
- PR 519: cast value to float
- Decrease error count for sniffer related issues
- ESDEV-4176 ESDEV-4177 0006557 0006558 Move classes for backward compatibility to separate folder
- PR 502/0006534: adjusted link to O'Reilly OXID eShop book 
- ESDEV-4183 Extract modules tests to different file

### Deprecated

### Removed
- PR 504: remove duplicate if-statement
- 0006543 Removes duplicated delete button
- Delete not used namespace and type hint from CategoryMain

### Fixed

### Security
