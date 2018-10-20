import { StarterModule } from './starter.module';

describe('StarterModule', () => {
  let starterModule: StarterModule;

  beforeEach(() => {
    starterModule = new StarterModule();
  });

  it('should create an instance', () => {
    expect(starterModule).toBeTruthy();
  });
});
