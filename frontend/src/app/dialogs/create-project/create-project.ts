import { Component, inject } from '@angular/core';
import { MatDialogRef } from '@angular/material/dialog';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule, FormControl } from '@angular/forms';
import { ProjectService } from '../../services/project';
import { MaterialModule } from '../../shared/material/material-module';
import { CommonModule } from '@angular/common';
import { MatSnackBar } from '@angular/material/snack-bar';

@Component({
  standalone: true,
  imports: [CommonModule, MaterialModule, ReactiveFormsModule],
  templateUrl: './create-project.html',
  styleUrls: ['./create-project.css']
})
export class CreateProjectDialogComponent {

  private projectService = inject(ProjectService);
  private snack = inject(MatSnackBar);
  dialogRef = inject(MatDialogRef<CreateProjectDialogComponent>);

  form = new FormGroup({
    name: new FormControl<string>('', { nonNullable: true, validators: [Validators.required] }),
    description: new FormControl<string>('', { nonNullable: true }),
    status: new FormControl<string>('open', { nonNullable: true, validators: [Validators.required] })
  });

  create() {
    if (this.form.invalid) return;

    this.projectService.createProject(this.form.value).subscribe({
      next: () => {
        this.snack.open('Project created successfully!', 'OK', { duration: 2000 });
        this.dialogRef.close(true);
      },
      error: () => {
        this.snack.open('Failed to create project', 'OK', { duration: 2000 });
      }
    });
  }
}
