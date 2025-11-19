import { Component, signal } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-search-component',
  imports: [],
  templateUrl: './search.component.html',
  styleUrl: './search.component.scss',
})
export class SearchComponent {
  query = signal('');
  constructor(private router: Router) {}
  onSearch(value?: string) {
    const searchQuery = (value ?? this.query()).trim();
    if (searchQuery) {
      this.router.navigate(['/results', searchQuery], { queryParams: { source: 'search' } });
    }
  }
}
