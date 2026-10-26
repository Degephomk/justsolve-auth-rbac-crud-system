import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MaterialModule } from '../../shared/material/material-module';
import { ProjectService } from '../../services/project';
import { AuthService } from '../../services/auth';
import { MatTableDataSource } from '@angular/material/table';
import { MatDialog } from '@angular/material/dialog';
import { PageEvent } from '@angular/material/paginator';
import { Sort } from '@angular/material/sort';
import { Subject, debounceTime } from 'rxjs';
import { finalize } from 'rxjs/operators';


import { CreateProjectDialogComponent } from '../../dialogs/create-project/create-project';
import { EditProjectDialogComponent } from '../../dialogs/edit-project/edit-project';
import { ConfirmDeleteDialogComponent } from '../../dialogs/confrim-delete/confirm-delete';

@Component({
  standalone: true,
  imports: [CommonModule, MaterialModule],
  templateUrl: './projects.html',
  styleUrls: ['./projects.css']   // ✅ FIXED - REQUIRED
})
export class ProjectsComponent implements OnInit {

  private projectService = inject(ProjectService);
  private dialog = inject(MatDialog);
  private auth = inject(AuthService);

  columns = ['name', 'status', 'owner', 'actions'];
  dataSource = new MatTableDataSource<any>([]);

  page = 1;
  limit = 10;
  total = 0;

  sortColumn: string = 'name';
  sortDirection: 'asc' | 'desc' = 'asc';

  search: string = '';
  private searchSubject = new Subject<string>();

  ngOnInit() {
    this.searchSubject.pipe(debounceTime(400)).subscribe(value => {
      this.search = value;
      this.page = 1;
      this.loadProjects();
    });

    this.loadProjects();
  }

  loadProjects() {
    this.projectService.getProjects({
      page: this.page,
      limit: this.limit,
      sort: this.sortColumn,
      direction: this.sortDirection,
      search: this.search
    }).subscribe((res: any) => {
      this.dataSource.data = res.data;
      this.total = res.meta.total;
      this.limit = res.meta.per_page;
      this.page = res.meta.current_page;
    });
  }

  onPageChange(event: PageEvent) {
    this.page = event.pageIndex + 1;
    this.limit = event.pageSize;
    this.loadProjects();
  }

  onSortChange(event: Sort) {
    if (!event.active || event.direction === '') {
      this.sortColumn = 'name';
      this.sortDirection = 'asc';
    } else {
      this.sortColumn = event.active;
      this.sortDirection = event.direction as 'asc' | 'desc';
    }
    this.loadProjects();
  }

  onSearchChange(event: any) {
    this.searchSubject.next(event.target.value);
  }

  clearSearch() {
    this.search = '';
    this.searchSubject.next('');
  }

  canEdit(project: any) {
    const user = this.auth.getUser();
    return this.auth.isAdmin() || project?.owner?.id === user?.id;
  }

  canDelete(project: any) {
    const user = this.auth.getUser();
    return this.auth.isAdmin() || project?.owner?.id === user?.id;
  }

  openCreateDialog() {
    this.dialog.open(CreateProjectDialogComponent, { width: '500px' })
      .afterClosed().subscribe(result => {
        if (result) this.loadProjects();
      });
  }

  openEditDialog(project: any) {
  this.dialog.open(EditProjectDialogComponent, {
    width: '520px',
    maxWidth: '95vw',
    data: project
  }).afterClosed().subscribe(result => {
    if (result) this.loadProjects();
  });
}


delete(project: any) {
  const dialogRef = this.dialog.open(ConfirmDeleteDialogComponent, {
    width: '400px',
    data: { name: project.name }
  });

  dialogRef.afterClosed().subscribe((confirmed: boolean) => {
    if (!confirmed) return;

    this.projectService.deleteProject(project.id)
      .pipe(
        finalize(() => this.loadProjects())   // 🔥 Will refresh always
      )
      .subscribe({
        next: () => {},
        error: () => alert('Delete failed')
      });
  });
}

}
