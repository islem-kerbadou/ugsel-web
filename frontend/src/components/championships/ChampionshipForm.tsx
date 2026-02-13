import React, { useState } from 'react';
import { Input } from '../common/Input';
import { Button } from '../common/Button';
import { ErrorMessage } from '../common/ErrorMessage';

interface ChampionshipFormProps {
  onSubmit: (name: string) => Promise<void>;
  onCancel?: () => void;
  competitionName?: string;
}

export const ChampionshipForm: React.FC<ChampionshipFormProps> = ({
  onSubmit,
  onCancel,
  competitionName,
}) => {
  const [name, setName] = useState('');
  const [error, setError] = useState<string | null>(null);
  const [submitting, setSubmitting] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError(null);

    if (!name.trim()) {
      setError('Le nom du championnat est requis');
      return;
    }

    try {
      setSubmitting(true);
      await onSubmit(name.trim());
      setName('');
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Erreur lors de la création du championnat');
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <form className="bg-light p-2 rounded border" onSubmit={handleSubmit}>
      {competitionName && (
        <div className="mb-2 pb-2 border-bottom">
          <small className="text-muted">Compétition: <strong>{competitionName}</strong></small>
        </div>
      )}

      {error && <ErrorMessage message={error} onDismiss={() => setError(null)} />}

      <Input
        label="Nom du championnat"
        value={name}
        onChange={setName}
        placeholder="Ex: Saison 2024, Tournoi de printemps..."
        required
        error={error && !name.trim() ? 'Le nom est requis' : undefined}
      />

      <div className="d-flex gap-2 justify-content-end">
        <Button type="submit" size="sm" disabled={submitting}>
          {submitting ? 'Création...' : 'Créer le championnat'}
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
