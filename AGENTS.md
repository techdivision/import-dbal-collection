# AGENTS.md - import-dbal-collection

## Zweck & Verantwortung

Das `import-dbal-collection` Modul bietet eine **hochoptimierte DBAL-Implementierung** basierend auf Collections mit Event-Support. Es ist ein **Tier 2 Modul** und erweitert `import-dbal` mit Performance-Optimierungen.

**Hauptverantwortung:**
- Hyperfast DBAL-Implementierung für große Datenmengen
- Event-Driven Architektur für Hooks
- Collection-basierte Repository-Implementierungen
- Performance-Optimierungen für Bulk-Operationen

## Architektur & Design Patterns

### Implementierungen
- **CollectionRepository**: Basis-Repository mit Collections
- **ProductRepository**: Spezialisiert für Produkte
- **CategoryRepository**: Spezialisiert für Kategorien
- **CustomerRepository**: Spezialisiert für Kunden

### Verwendete Patterns
- **Repository Pattern**: Implementiert `RepositoryInterface`
- **Event-Driven**: Nutzt `league/event` für Hooks
- **Collection Pattern**: In-Memory Collections für Performance
- **Observer Pattern**: Für Row-Level Processing

### Externe Dependencies
- **league/event** - Event-System für Hooks

## Abhängigkeiten

### Externe Pakete
- **league/event** ^2.0|^3.0 - Event-System

### TechDivision Dependencies
- **import-dbal** ^2.0 - Implementiert DBAL-Interfaces
- **import-cache** ^2.0 - Für Cache-Integration

### Abhängig von diesem Modul (2 Reverse Dependencies)
1. **import** - Core Framework nutzt DBAL-Implementierung
2. **import-cli-simple** - Transitiv über andere Module

## Wichtige Entry Points

### Repository Klassen
```php
// Collection Repository
CollectionRepository::create($row): void
CollectionRepository::update($row): void
CollectionRepository::delete($row): void
CollectionRepository::findOne($id): array
CollectionRepository::findAll(): array

// Event Listeners
RepositoryEventListener::onBeforeCreate($event): void
RepositoryEventListener::onAfterCreate($event): void
```

### Verwendungsbeispiel
```php
// In Importern
$repository = new CollectionRepository();
$repository->create(['sku' => 'PRODUCT-1', 'name' => 'Product 1']);
$product = $repository->findOne(['sku' => 'PRODUCT-1']);
$repository->update(['sku' => 'PRODUCT-1', 'name' => 'Updated Name']);
```

## Events & Extension Points

### Events
- **BeforeCreateEvent**: Vor Create-Operation
- **AfterCreateEvent**: Nach Create-Operation
- **BeforeUpdateEvent**: Vor Update-Operation
- **AfterUpdateEvent**: Nach Update-Operation
- **BeforeDeleteEvent**: Vor Delete-Operation
- **AfterDeleteEvent**: Nach Delete-Operation

### Listener-Registrierung
```php
// In Konfiguration
$eventManager->addListener('before.create', new CustomListener());
```

## Hints für KI-Agenten

### Wichtig zu verstehen
1. **Tier 2 Modul**: Erweitert Tier 1 mit Event-Support
2. **Hyperfast**: Optimiert für große Datenmengen
3. **Event-Driven**: Zentral für Extensibility
4. **Collection-basiert**: In-Memory Collections für Performance

### Bei Änderungen
- **Event-Kompatibilität**: Beachte bestehende Event-Listener
- **Performance**: Beachte Memory-Footprint bei großen Datenmengen
- **Backward Compatibility**: Neue Events sollten optional sein

### Implementierungs-Hinweise
- Nutze Events für Custom Processing
- Beachte Event-Reihenfolge (Before → Operation → After)
- Erwäge Listener-Prioritäten für Execution-Order

## Bekannte Einschränkungen

- **In-Memory Collections**: Nicht für sehr große Datenmengen geeignet
- **Keine Transaktionen**: Transaktions-Handling erfolgt in Importern
- **Event-Overhead**: Events können Performance beeinflussen
- **Keine Persistierung**: Daten gehen verloren bei Prozess-Ende

## Zusammenfassung

`import-dbal-collection` ist ein **Tier 2 Modul**, das eine hochoptimierte, event-driven DBAL-Implementierung bietet. Es ist zentral für die Performance des Pacemaker-Systems und ermöglicht Extensibility durch Events.

**Für Agenten:** Verstehe dieses Modul als **DBAL-Implementierung mit Event-Support** für Performance und Extensibility.
