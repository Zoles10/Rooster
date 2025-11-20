# Test Suite Documentation

This directory contains the complete test suite for the Rooster application, organized into different testing levels following Laravel testing best practices.

## Test Structure

```
tests/
├── Unit/                    # Pure unit tests (isolated, fast)
├── Integration/             # Integration tests (multiple components)
├── Feature/                 # Feature tests (full application flow)
└── TestCase.php            # Base test case class
```

## Test Categories

### 🔧 Unit Tests (`/Unit`)
- **Purpose**: Test individual classes/methods in isolation
- **Characteristics**: Fast, mocked dependencies, no external resources
- **Files**: 
  - `LocaleControllerTest.php` - Locale switching functionality
  - `ManualControllerTest.php` - PDF generation logic
  - `ProfileControllerTest.php` - Profile management methods
  - `WelcomeControllerTest.php` - Welcome page controller

### 🔗 Integration Tests (`/Integration`)
- **Purpose**: Test interaction between multiple components
- **Files**:
  - `AnswerControllerTest.php`
  - `QuestionControllerTest.php` 
  - `QuizControllerTest.php`

### 🌐 Feature Tests (`/Feature`)
- **Purpose**: Test complete user workflows and application features
- **Files**:
  - `ExampleTest.php`
  - `ProfileTest.php`
  - `Auth/` - Authentication-related feature tests

## Running Tests

### Run All Tests
```bash
php artisan test
```

### Run Specific Test Categories

**Unit Tests Only:**
```bash
php artisan test tests/Unit
```

**Integration Tests Only:**
```bash
php artisan test tests/Integration
```

**Feature Tests Only:**
```bash
php artisan test tests/Feature
```

### Run Individual Test Files
```bash
# Run specific test file
php artisan test tests/Unit/ProfileControllerTest.php

# Run specific test method
php artisan test --filter testWelcomeReturnsWelcomeView
```

### Additional Test Options

**Stop on First Failure:**
```bash
php artisan test --stop-on-failure
```

## Test Environment

Make sure you have:
- ✅ PHPUnit installed via Composer
- ✅ `.env.testing` configured for test database
- ✅ Test database properly set up
- ✅ Mockery for mocking (included in Laravel)

## Best Practices

1. **Unit Tests**: Should run in < 100ms each
2. **Integration Tests**: Test component interactions
3. **Feature Tests**: Test complete user scenarios
4. **Always clean up**: Use proper tearDown methods
5. **Mock external dependencies**: Keep tests isolated and fast

---

*Total Test Files: 14 | Categories: Unit (4), Integration (3), Feature (7)*
