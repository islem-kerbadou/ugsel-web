import React, { useState } from 'react';
import { Input } from '../common/Input';
import { Button } from '../common/Button';
import { ErrorMessage } from '../common/ErrorMessage';

interface CompetitionFormProps {
  onSubmit: (name: string) => Promise<void>;
  onCancel?: () => void;
  sportName?: string;
}

export const CompetitionForm: React.FC<CompetitionFormProps> = ({
  onSubmit,
  onCancel,
  sportName,
}) => {
  const [name, setName] = useState('');
  const [error, setError] = useState<string | null>(null);
  const [submitting, setSubmitting] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError(null);

    if (!name.trim()) {
      setError('Le nom de la compétition est requis');
      return;
    }

    try {
      setSubmitting(true);
      await onSubmit(name.trim());
      setName('');
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Erreur lors de la création de la compétition');
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <form className="bg-light p-3 rounded border" onSubmit={handleSubmit}>
      {sportName && (
        <div className="mb-2 pb-2 border-bottom">
          <small className="text-muted">Sport: <strong>{sportName}</strong></small>
        </div>
      )}

      {error && <ErrorMessage message={error} onDismiss={() => setError(null)} />}

      <Input
        label="Nom de la compétition"
        value={name}
        onChange={setName}
        placeholder="Ex: Ligue 1, Coupe de France..."
        required
        error={error && !name.trim() ? 'Le nom est requis' : undefined}
      />

      <div className="d-flex gap-2 justify-content-end">
        <Button type="submit" size="sm" disabled={submitting}>
          {submitting ? 'Création...' : 'Créer la compétition'}
        </Button>
        {onCancel && (
          <Button type="button" variant="secondary" size="sm" onClick={onCancel}>
            Annuler
          </Button>
        )}
      </div>
    </form>
  );
};
