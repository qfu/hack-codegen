<?hh // strict
/**
 * Copyright (c) 2015-present, Facebook, Inc.
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree. An additional grant
 * of patent rights can be found in the PATENTS file in the same directory.
 */

namespace Facebook\HackCodegen;

final class CodegenFunctionTest extends CodegenBaseTest {

  public function testSimpleGetter(): void {
    $code = $this->getCodegenFactory()
      ->codegenFunction('getName')
      ->setReturnType('string')
      ->setBody('return $name;')
      ->setDocBlock('Return the name of the user.')
      ->render();
    $this->assertUnchanged($code);
  }

  public function testParams(): void {
    $code = $this->getCodegenFactory()
      ->codegenFunction('getName')
      ->addParameter('string $name')
      ->setBody('return $name . $name;')
      ->render();
    $this->assertUnchanged($code);
  }

  public function testAsync(): void {
    $code = $this->getCodegenFactory()
      ->codegenFunction('genFoo')
      ->setIsAsync()
      ->render();
    $this->assertUnchanged($code);
  }

  public function testMemoize(): void {
    $code = $this->getCodegenFactory()
      ->codegenFunction('getExpensive')
      ->setIsMemoized(true)
      ->render();
    $this->assertUnchanged($code);
  }

  public function testOverride(): void {
    $code = $this->getCodegenFactory()
      ->codegenFunction('getNotLikeParent')
      ->setIsOverride(true)
      ->render();
    $this->assertUnchanged($code);
  }

  public function testOverrideAndMemoized(): void {
    $code = $this->getCodegenFactory()
      ->codegenFunction('getExpensiveNotLikeParent')
      ->setIsOverride(true)
      ->setIsMemoized(true)
      ->render();
    $this->assertUnchanged($code);
  }

  public function testOverrideMemoizedAsync(): void {
    $code = $this->getCodegenFactory()
      ->codegenFunction('genExpensiveNotLikeParent')
      ->setIsOverride(true)
      ->setIsMemoized(true)
      ->setIsAsync()
      ->render();
    $this->assertUnchanged($code);
  }

  public function testSingleUserAttributeWithoutArgument(): void {
    $code = $this->getCodegenFactory()
      ->codegenFunction('getTestsBypassVisibility')
      ->setUserAttribute('TestsBypassVisibility')
      ->render();
    $this->assertUnchanged($code);
  }

  public function testSingleUserAttributeWithArgument(): void {
    $code = $this->getCodegenFactory()
      ->codegenFunction('getUseDataProvider')
      ->setUserAttribute('DataProvider', "'providerFunc'")
      ->render();
    $this->assertUnchanged($code);
  }

  public function testMixedUserAttributes(): void {
    $code = $this->getCodegenFactory()
      ->codegenFunction('getBypassVisibilityAndUseDataProvider')
      ->setUserAttribute('DataProvider', "'providerFunc'")
      ->setUserAttribute('TestsBypassVisibility')
      ->render();
    $this->assertUnchanged($code);
  }

  public function testMixedBuiltInAndUserAttributes(): void {
    $code = $this->getCodegenFactory()
      ->codegenFunction('getOverridedBypassVisibilityAndUseDataProvider')
      ->setIsOverride(true)
      ->setUserAttribute('DataProvider', "'providerFunc'")
      ->setUserAttribute('TestsBypassVisibility')
      ->render();
    $this->assertUnchanged($code);
  }

  public function testMixedBuiltInAndUserAttributesAsync(): void {
    $code = $this->getCodegenFactory()
      ->codegenFunction('genOverridedBypassVisibilityAndUseDataProvider')
      ->setIsOverride(true)
      ->setUserAttribute('DataProvider', "'providerFunc'")
      ->setUserAttribute('TestsBypassVisibility')
      ->setIsAsync()
      ->render();
    $this->assertUnchanged($code);
  }

  public function testManualSection(): void {
    $code = $this->getCodegenFactory()
      ->codegenFunction('genProprietorName')
      ->setReturnType('string')
      ->setBody('// insert your code here')
      ->setManualBody()
      ->render();
    $this->assertUnchanged($code);
  }

  public function testDocBlockCommentsWrap(): void {
    $cgf = $this->getCodegenFactory();
    // 1-3 characters in doc block account for ' * ' in this test.
    $code = $cgf->codegenFunction('getName')
      ->setReturnType('string')
      ->setBody('return $name;')
      // 81 characters
      ->setDocBlock(str_repeat('x', 78))
      ->setGeneratedFrom($cgf->codegenGeneratedFromClass('EntTestSchema'))
      ->render();
    $this->assertUnchanged($code);
  }
}
