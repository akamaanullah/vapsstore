# Changelog

All notable changes to **The Perfect Vape** project will be documented in this file.

## [1.2.0] - 2026-05-13
### Added
- **MIT License**: Added official license file with author attribution.
- **Production README**: Completely rewritten documentation with architecture details, setup guides, and security overview.
- **Unified Error Logging**: Moved logs from `scratch/` to `storage/logs/` and updated `ErrorHandler`.
- **Author Branding**: Integrated [amaanullah.com](https://amaanullah.com) contact and info links.

### Changed
- **Dynamic Navigation System**: Finalized the entity-linked navigation that auto-updates URLs when slugs change in the admin panel.
- **SEO Routing**: Enhanced `Router` with 301 canonicalization and prefix-stripping logic.
- **Model Signatures**: Standardized `all($limit = 1000)` signature across all models to ensure PHP compatibility.

### Fixed
- **Fatal Error**: Fixed method signature mismatch in `Setting`, `Coupon`, and `BlogPost` models.
- **Syntax Error**: Fixed missing comma in `MenuController` product search API results.
- **Security**: Updated Content Security Policy (CSP) in `.htaccess` to allow essential CDNs.

### Removed
- **Junk Cleanup**: Deleted **76+ scratch files**, debug scripts, and old SQL dumps (`database.sql`, `vapestore.sql`, etc.) to prepare for production.

---

## [1.1.0] - 2026-05-11
### Added
- **Media Gallery**: Centralized media management system for images.
- **Section Builder**: Polymorphic UI section builder for homepage and dynamic pages.

---

## [1.0.0] - 2026-05-04
### Added
- **Initial Release**: Core MVC framework, User Authentication, and Basic Product/Collection CRUD.
