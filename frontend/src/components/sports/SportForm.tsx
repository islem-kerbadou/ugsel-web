import React, { useState, useEffect } from 'react';
import { Input } from '../common/Input';
import { Select } from '../common/Select';
import { Button } from '../common/Button';
import { ErrorMessage } from '../common/ErrorMessage';
import { SportTypeForm } from '../sport-types/SportTypeForm';
import { useSportTypes } from '../../hooks/useSportTypes';
import { SportType } from '../../types';

interface SportFormProps {
  onSubmit: (name: string, sportType: string) => Promise<void>;
  onCancel?: () => void;
  initialSportType?: string;
}

export const SportForm: React.FC<SportFormProps> = ({
  onSubmit,
  onCancel,
  initialSportType,
}) => {
  const { sportTypes, loading: typesLoading, createSportType, refetch } = useSportTypes();
  const [name, setName] = useState('');
  const [selectedSportType, setSelectedSportType] = useState(initialSportType || '');
  const [error, setError] = useState<string | null>(null);
  const [submitting, setSubmitting] = useState(false);
  const [showSportTypeForm, setShowSportTypeForm] = useState(false);

  useEffect(() => {
    if (initialSportType) {
      setSelectedSportType(initialSportType);
    }
  }, [initialSportType]);

  useEffect(() => {
    if (sportTypes.length > 0 && !selectedSportType) {
      setSelectedSportType(`/api/sport_types/${sportTypes[0].id}`);
    }
  }, [sportTypes, selectedSportType]);

  const handleCreateSportType = async (
    code: string,
    label: string,
    types: ('individuel' | 'collectif')[]
  ) => {
    try {
      const newSportType = await createSportType(code, label, types);
      setSelectedSportType(`/api/sport_types/${newSportType.id}`);
      setShowSportTypeForm(false);
      await refetch();
    } catch (err) {
      throw err;
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError(null);

    if (!name.trim()) {
      setError('Le nom du sport est requis');
      return;
    }

    if (!selectedSportType) {
      setError('Le type de sport est requis');
      return;
    }

    try {
      setSubmitting(true);
      await onSubmit(name.trim(), selectedSportType);
      setName('');
      setSelectedSportType('');
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Erreur lors de la création du sport');
    } finally {
      setSubmitting(false);
    }
  };

  const getSportTypeOptions = () => {
    return sportTypes.map((st: SportType) => ({
      value: `/api/sport_types/${st.id}`,
      label: `${st.label || st.code}${st.types ? ` (${st.types.join(', ')})` : ''}`,
    }));
  };

  if (typesLoading) {
    return (
      <div className="text-center p-5">
        <div className="spinner-border text-primary" role="status">
          <span className="visually-hidden">Chargement...</span>
        </div>
        <p className="mt-3 text-muted">Chargement des types de sport...</p>
      </div>
    );
  }

  return (
    <div className="container">
      <div className="row justify-content-center">
        <div className="col-md-8 col-lg-6">
          <div className="card shadow-sm">
            <div className="card-body p-4">
              <h2 className="card-title mb-4">Créer un nouveau sport</h2>

              {error && <ErrorMessage message={error} onDismiss={() => setError(null)} />}

              <form onSubmit={handleSubmit}>
                <Input
                  label="Nom du sport"
                  value={name}
                  onChange={setName}
                  placeholder="Ex: Football, Tennis, Basketball..."
                  required
                  error={error && !name.trim() ? 'Le nom est requis' : undefined}
                />

                {sportTypes.length === 0 ? (
                  <div className="alert alert-warning">
                    <p className="mb-3">
                      ⚠️ Aucun type de sport disponible. Veuillez créer un type de sport avant de créer un sport.
                    </p>
                    {!showSportTypeForm && (
                      <Button
                        type="button"
                        onClick={() => setShowSportTypeForm(true)}
                        className="w-100"
                      >
                        + Créer un type de sport
                      </Button>
                    )}
                  </div>
                ) : (
                  <div className="d-flex gap-2 align-items-end">
                    <div className="flex-grow-1">
                      <Select
                        label="Type de sport"
                        value={selectedSportType}
                        onChange={setSelectedSportType}
                        options={getSportTypeOptions()}
                        placeholder="Sélectionnez un type"
                        required
                        error={error && !selectedSportType ? 'Le type est requis' : undefined}
                      />
                    </div>
                    {!showSportTypeForm && (
                      <Button
                        type="button"
                        variant="secondary"
                        onClick={() => setShowSportTypeForm(true)}
                        className="mb-3"
                      >
                        + Ajouter
                      </Button>
                    )}
                  </div>
                )}

                {showSportTypeForm && (
                  <div className="mb-3">
                    <SportTypeForm
                      onSubmit={handleCreateSportType}
                      onCancel={() => setShowSportTypeForm(false)}
                      inline
                    />
                  </div>
                )}

                <div className="d-flex gap-2 justify-content-end">
                  <Button type="submit" disabled={submitting || sportTypes.length === 0}>
                    {submitting ? 'Création...' : 'Créer le sport'}
                  </Button>
                  {onCancel && (
                    <Button type="button" variant="secondary" onClick={onCancel}>
                      Annuler
                    </Button>
                  )}
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
