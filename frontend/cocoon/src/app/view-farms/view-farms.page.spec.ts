import { CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ViewFarmsPage } from './view-farms.page';

describe('ViewFarmsPage', () => {
  let component: ViewFarmsPage;
  let fixture: ComponentFixture<ViewFarmsPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ViewFarmsPage ],
      schemas: [CUSTOM_ELEMENTS_SCHEMA],
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ViewFarmsPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
